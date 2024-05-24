<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\DiscountCoupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingCharges;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::with('product_image')->find($request->id);

        if ($product == null) {
            return response()->json([
                'status' => true,
                'message' => 'Produto não encontrado'
            ]);
        }
        if (Cart::count() > 0) {

            $cartContent = Cart::content();
            $productAlreadyExist = false;
            foreach ($cartContent as $item) {
                if ($item->id == $product->id) {
                    $productAlreadyExist = true;
                }
            }
            if ($productAlreadyExist == false) {
                Cart::add(
                    $product->id,
                    $product->title,
                    1,
                    $product->price,
                    ['productImage' => (!empty($product->product_image)) ? $product->product_image->first() : '']
                );
                $status = true;
                $message = '<strong>' . $product->title . '</strong> adicionado ao carrinho com sucesso.';
                session()->flash('success', $message);
            } else {
                $status = false;
                $message = '<strong>' . $product->title . '</strong> já adicionado ao carrinho.';
                session()->flash('error', $message);
            }
        } else {
            Cart::add(
                $product->id,
                $product->title,
                1,
                $product->price,
                ['productImage' => (!empty($product->product_image)) ? $product->product_image->first() : '']
            );
            $status = true;
            $message = '<strong>' . $product->title . '</strong> adicionado ao carrinho com sucesso.';
            session()->flash('success', $message);
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function cart()
    {
        $cartContnt =  Cart::content();

        return view('front.cart', compact('cartContnt'));
    }
    public function updateCart(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;
        $itemInfo = Cart::get($rowId);
        $product = Product::find($itemInfo->id);
        // Verificar quantidade disponível em estoque
        if ($product->track_qty == 'Yes') {
            if ($qty <= $product->qty) {
                Cart::update($rowId, $qty);
                $message = 'Carrinho atualizado com sucesso';
                $status = true;
                session()->flash('success', $message);
            } else {
                $message = 'Quantidade solicitada (' . $qty . ') não disponível em estoque.';
                $status = false;
                session()->flash('error', $message);
            }
        } else {
            Cart::update($rowId, $qty);
            $message = 'Carrinho atualizado com sucesso';
            $status = true;
            session()->flash('success', $message);
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function deleteItem(Request $request)
    {
        $itemInfo = Cart::get($request->rowId);
        if ($itemInfo == null) {
            $errorMessage = 'Item não encontrado no carrinho';
            session()->flash('error', $errorMessage);
            return response()->json([
                'status' => false,
                'message' => $errorMessage
            ]);
        }
        Cart::remove($request->rowId);
        $message = 'Item removido do carrinho com sucesso.';
        session()->flash('error', $message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    function checkout()
    {
        $discount = 0;
        // if cart is empty rediret to cart 
        if (Cart::count() == 0) {
            return redirect()->route('front.cart');
        }
        if (Auth::check() == false ||  Auth::user()->id == null) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
                return redirect()->route('account.login');
            }
        }
        $customerAddrees = CustomerAddress::where('user_id', Auth::user()->id)->first();
        session()->forget('url.intended');
        $countries = Country::orderBy('name', 'ASC')->get();
        $subTotal = Cart::subtotal(2, '.', '');
        //apply discount here
        if (session()->has('code')) {
            $code = session()->get('code');
            if ($code->type == 'percent') {
                $discount = ($code->discount_amount / 100) * $subTotal;
            } else {
                $discount = $code->discount_amount;
            }
        }

        // Calculate shipping here
        $userCountry = $customerAddrees->country_id;
        $shippingInfo = ShippingCharges::where('country_id', $userCountry)->first();
        $totalQty = 0;
        $totalShippingCharge = 0;
        foreach (Cart::content() as $item) {
            $totalQty += $item->qty;
        }
        if ($shippingInfo != null) {
            $totalShippingCharge = $totalQty *  $shippingInfo->amount;
        }
        $grandTotal = ($subTotal - $discount) + $totalShippingCharge;
        return  view('front.checkout', compact(
            'countries',
            'customerAddrees',
            'totalShippingCharge',
            'grandTotal',
            'discount'
        ));
    }
    public function processCheckout(Request $request)
    {
        // step - 1 Apply Validation
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:5',
            'last_name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required|min:30',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Pleaase fix the errors',
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        $user = Auth::user();
        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'country_id' => $request->country,
                'address' => $request->address,
                'apartment' => $request->appartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
            ]
        );
        // step 3 store data in orders table
        if ($request->payment_method == 'cod') {
            $shipping = 0;
            $discount = 0;
            $discountCodeId = 0;
            $promoCode = '';
            $subTotal = Cart::subtotal(2, '.', '');
            $grandTotal = $subTotal + $shipping;

            //apply discount here
            if (session()->has('code')) {
                $code = session()->get('code');
                if ($code->type == 'percent') {
                    $discount = ($code->discount_amount / 100) * $subTotal;
                } else {
                    $discount = $code->discount_amount;
                }

                $discountCodeId = $code->id;
                $promoCode = $code->code;
            }
            $shippingInfo = ShippingCharges::where('country_id', $request->country)->first();
            $totalQty = 0;
            foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
            }
            if ($shippingInfo != null) {
                $shipping = $totalQty * $shippingInfo->amount;
                $grandTotal = ($subTotal - $discount) + $shipping;
            } else {
                $grandTotal = ($subTotal - $discount);
                $shipping = 0;
            }




            $order = new Order();
            $order->subtotal = $subTotal;
            $order->shipping = $shipping;
            $order->grand_total = $grandTotal;
            $order->discount = $discount;
            $order->coupon_code_id = $discountCodeId;
            $order->coupon_code = $promoCode;
            $order->payment_status = 'not paid';
            $order->status = 'pending';
            $order->user_id =  $user->id;
            // Informações do cliente
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;

            // Informações de entrega
            $order->country_id = $request->country;
            $order->address = $request->address;
            $order->apartment = $request->appartment;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->zip = $request->zip;

            $order->save();

            // step 4 store order items in order items table
            foreach (Cart::content() as $item) {
                $orderItem = new OrderItem;
                $orderItem->product_id = $item->id;
                $orderItem->order_id = $order->id;
                $orderItem->name = $item->name;
                $orderItem->qty = $item->qty;
                $orderItem->price = $item->price;
                $orderItem->total = $item->price * $item->qty;
                $orderItem->save();
            }
            Cart::destroy();
            session()->flash('success', 'You have successfully placed your order.');
            session()->forget('code');
            return response()->json([
                'message' => 'Order saved successfully.',
                'orderId' => $order->id,
                'status' => true
            ]);
        } else { //
        }
    }
    public function thankyou($id)
    {
        return view('front.thanks', compact('id'));
    }
    public function getOrderSummery(Request $request)
    {
        $subTotal = Cart::subtotal(2, '.', '');
        $discount = 0;
        $discountString = '';
        //apply discount here
        if (session()->has('code')) {
            $code = session()->get('code');
            if ($code->type == 'percent') {
                $discount = ($code->discount_amount / 100) * $subTotal;
            } else {
                $discount = $code->discount_amount;
            }
            $discountString = '<div class=" mt-4" id="discount-response">
            <strong class="ps-1">' . session()->get('code')->code . ' </strong>
              <a class="btn btn-sm btn-danger" id="remove-discount">
                <i class="fa fa-times"></i>
             </a>
           </div>';
        }



        if ($request->country_id > 0) {
            $shippingInfo = ShippingCharges::where('country_id', $request->country_id)->first();
            $totalQty = 0;
            foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
            }
            if ($shippingInfo != null) {
                $shippingCharge = $totalQty * $shippingInfo->amount;
                $grandTotal = ($subTotal - $discount) + $shippingCharge;
                return      response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal, 2),
                    'discount' => number_format($discount, 2),
                    'discountString' => $discountString,
                    'shippingCharge' => number_format($shippingCharge, 2),

                ]);
            } else {
                return  response()->json([
                    'status' => true,
                    'grandTotal' => number_format(($subTotal - $discount), 2),
                    'discount' => number_format($discount, 2),
                    'discountString' => $discountString,
                    'shippingCharge' => number_format(0, 2),

                ]);
            }
        } else {
            return  response()->json([
                'status' => true,
                'grandTotal' => number_format(($subTotal - $discount), 2),
                'discount' => number_format($discount, 2),
                'discountString' => $discountString,
                'shippingCharge' => number_format(0, 2),

            ]);
        }
    }
    public function applyDiscount(Request $request)
    {

        $code = DiscountCoupon::where('code', $request->code)->first();

        if ($code == null) {

            return response()->json([
                'status' => false,
                'message' => 'invalid discount coupon1',
            ]);
        }

        // check if coupon start date is valid or not 
        $now = Carbon::now();

        if ($code->start_at != "") {
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->start_at);
            if ($now->lt($startDate)) {
                return response()->json([
                    'status' => false,
                    'message' => 'invalid discount coupon2',
                ]);
            }
        }
        if ($code->expires_at != "") {
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->expires_at);
            if ($now->gt($endDate)) {
                return response()->json([
                    'status' => false,
                    'message' => 'invalid discount coupon4',
                ]);
            }
        }

        // Max uses check
        if ($code->max_uses > 0) {
            $couponUsed = Order::where('coupon_code_id', $code->id)->count();
            if ($couponUsed >= $code->max_uses) {
                return response()->json([
                    'status' => false,
                    'message' => 'Atingiu o limite de uso cartao de desconto',
                ]);
            }
        }
        //max uses user chack
        if ($code->max_uses_user > 0) {
            $couponUsedByUser = Order::where(['coupon_code_id' => $code->id, 'user_id' => Auth::id()])->count();
            if ($couponUsedByUser >= $code->max_uses_user) {
                return response()->json([
                    'status' => false,
                    'message' => 'You already used this coupon.',
                ]);
            }
        }
        $subTotal = Cart::subtotal(2, '.', '');
        //   minumom amount condicion check
        if ($code->min_amount > 0) {
            if ($subTotal < $code->min_amount) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your min amount must be ' . number_format($code->min_amount, 2) . ' AOA.',
                ]);
            }
        }
        session()->put('code', $code);
        return $this->getOrderSummery($request);
    }
    public function removeCoupon(Request $request)
    {
        session()->forget('code');
        return $this->getOrderSummery($request);
    }
}
