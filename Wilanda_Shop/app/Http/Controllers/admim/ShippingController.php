<?php

namespace App\Http\Controllers\admim;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\ShippingCharges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function create()
    {
        $countries = Country::get();
        $shippingCharges = ShippingCharges::select('shipping_charges.*', 'countries.name')
        ->latest('shipping_charges.id')
       -> leftJoin('countries', 'countries.id', 'shipping_charges.country_id');
        $shippingCharges =$shippingCharges ->paginate(5);
        return view('admin.shipping.create', compact('countries','shippingCharges'));
    }

    public function store(Request $request)
    {
        $validator =  Validator::make(
            $request->all(),
            [
                'country_id' => 'required|unique:shipping_charges',
                'amount' => 'required|numeric'
            ],
            [
                'country_id.required' => 'O campo country  é obrigatório.',
                'country_id.unique' => 'O country já está em uso. Por favor, escolha outro.',
                'amount.required' => 'O campo amount é obrigatório.',
                'amount.numeric' => 'A amount deve ser um valor numérico.',
            ]
        );
        if ($validator->passes()) {

            $shippingCharges = new ShippingCharges();
            $shippingCharges->country_id = $request->country_id;
            $shippingCharges->amount = $request->amount;
            $shippingCharges->save();

            session()->flash('success', ' adiconado com sucesso');
            return response([
                'status' => true,
                'message' => ' adiconado com sucesso'
            ]);
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($shipping_id)
    {
       
        $shippingCharge = ShippingCharges::find($shipping_id);
        $countries = Country::get();
        return view('admin.shipping.edit', compact('countries','shippingCharge'));
    }
    public function update(Request $request, $shipping_id)
    {
        $validator =  Validator::make(
            $request->all(),
            [
                'country_id' => 'required|unique:shipping_charges,country_id,' .$shipping_id . ',id',
                'amount' => 'required|numeric'
            ],
            [
                'country_id.required' => 'O campo country  é obrigatório.',
                'country_id.unique' => 'O country já está em uso. Por favor, escolha outro.',
                'amount.required' => 'O campo amount é obrigatório.',
                'amount.numeric' => 'A amount deve ser um valor numérico.',
            ]
        );
        if ($validator->passes()) {
            $shippingCharge = ShippingCharges::find($shipping_id);
            $shippingCharge->country_id = $request->country_id;
            $shippingCharge->amount = $request->amount;
            $shippingCharge->save();

            session()->flash('success', ' editada com sucesso');
            return response([
                'status' => true,
                'message' => ' editada com sucesso'
            ]);
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy($shipping_id)
    {
        $shippingCharge = ShippingCharges::find($shipping_id);
       if (empty($shippingCharge)) {
 
          session()->flash('error', 'não entrada');
          // Retornar erros de validação em resposta JSON
          return response()->json([
             'status' => false,
             'message' => 'não entrada'
          ]);
       }
       $shippingCharge->delete();
       // Mostrar mensagem de sucesso e retornar resposta JSON
       session()->flash('success', 'Deletada com sucesso');
       // Retornar erros de validação em resposta JSON
       return response()->json([
          'status' => true,
          'message' => 'Deletada com sucesso'
       ]);
    }
}
