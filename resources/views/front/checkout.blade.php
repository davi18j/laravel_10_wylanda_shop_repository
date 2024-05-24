@extends('front.layout.app')
@section('main_Shop')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="#">Início</a></li>
                        <li class="breadcrumb-item"><a class="white-text" href="#">Loja</a></li>
                        <li class="breadcrumb-item">Finalizar compra</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-9 pt-4">
            <div class="container">
                <form id="orderForm" name="orderForm" action="" method="POST">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="sub-title">
                                <h2>Endereço de Envio</h2>
                            </div>
                            <div class="card shadow-lg border-0">
                                <div class="card-body checkout-form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" name="first_name" id="first_name" class="form-control"
                                                    placeholder="Nome"
                                                    value="{{ !empty($customerAddrees) ? $customerAddrees->first_name : '' }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" name="last_name" id="last_name" class="form-control"
                                                    placeholder="Sobrenome"
                                                    value="{{ !empty($customerAddrees) ? $customerAddrees->last_name : '' }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" name="email" id="email" class="form-control"
                                                    placeholder="E-mail"
                                                    value="{{ !empty($customerAddrees) ? $customerAddrees->email : '' }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <select name="country" id="country" class="form-control">
                                                    <option value="">Selecione um País</option>
                                                    @if ($countries->isNotEmpty())
                                                        @foreach ($countries as $country)
                                                            <option
                                                                {{ !empty($customerAddrees && $customerAddrees->country_id == $country->id) ? 'selected' : '' }}
                                                                value="{{ $country->id }}">{{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <textarea name="address" id="address" cols="30" rows="3" placeholder="Endereço" class="form-control">{{ !empty($customerAddrees) ? $customerAddrees->address : '' }}</textarea>
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" name="appartment" id="appartment" class="form-control"
                                                    placeholder="Apartamento, suíte, unidade, etc. (opcional)"
                                                    value="{{ !empty($customerAddrees) ? $customerAddrees->appartment : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input type="text" name="city" id="city" class="form-control"
                                                    placeholder="Cidade"
                                                    value="{{ !empty($customerAddrees) ? $customerAddrees->city : '' }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input type="text" name="state" id="state" class="form-control"
                                                    placeholder="Estado"
                                                    value="{{ !empty($customerAddrees) ? $customerAddrees->state : '' }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input type="text" name="zip" id="zip" class="form-control"
                                                    placeholder="CEP"
                                                    value="{{ !empty($customerAddrees) ? $customerAddrees->zip : '' }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" name="mobile" id="mobile" class="form-control"
                                                    placeholder="Número de Celular"
                                                    value="{{ !empty($customerAddrees) ? $customerAddrees->mobile : '' }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <textarea name="order_notes" id="order_notes" cols="30" rows="2"
                                                    placeholder="Observações do Pedido (opcional)" class="form-control">{{ !empty($customerAddrees) ? $customerAddrees->order_notes : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sub-title">
                                <h2>Resumo do Pedido</h2>
                            </div>
                            <div class="card cart-summery">
                                <div class="card-body">
                                    @foreach (Cart::content() as $item)
                                        <div class="d-flex justify-content-between pb-2">
                                            <div class="h6">{{ $item->name }} X {{ $item->qty }}</div>
                                            <div class="h6">{{ $item->price * $item->qty }} AOA</div>
                                        </div>
                                    @endforeach

                                    <div class="d-flex justify-content-between summery-end">
                                        <div class="h6"><strong>Subtotal</strong></div>
                                        <div class="h6"><strong>{{ Cart::subtotal() }} AOA</strong></div>
                                    </div>

                                    <div class="d-flex justify-content-between summery-end">
                                        <div class="h6"><strong>Desconto</strong></div>
                                        <div class="h6"><strong id="discount_value">{{ $discount }} AOA</strong></div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-2">
                                        <div class="h6"><strong>Envio</strong></div>
                                        <div class="h6"><strong
                                                id="shippingAmount">{{ number_format($totalShippingCharge, 2) }}
                                                AOA</strong></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2 summery-end">
                                        <div class="h5"><strong>Total</strong></div>
                                        <div class="h5"><strong id="grandTotal">{{ number_format($grandTotal, 2) }}
                                                AOA </strong></div>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group apply-coupan mt-4">
                                <input type="text" placeholder="Código do Cupom" class="form-control" name="discount_code" id="discount_code">
                                <button class="btn btn-dark" type="button" id="apply_coupon">Aplicar Cupom</button>
                            </div>

                            <div id="discount-response-wrapper">
                            @if (Session::has('code'))
                            <div class=" mt-4" id="discount-response">
                                <strong class="ps-1"> {{Session::get('code')->code}}</strong>
                                <a class="btn btn-sm btn-danger" id="remove-discount">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                            @endif
                            </div>


                            <div class="card payment-form ">
                                <h3 class="card-title h5 mb-3">Método de Pagamento</h3>
                                <div class="">
                                    <input checked type="radio" name="payment_method" value="cod"
                                        id="payment_method_one">
                                    <label for="payment_method_one" class="form-check-label">Dinheiro na Entrega</label>
                                </div>
                                <div class="">
                                    <input type="radio" name="payment_method" value="cod" id="payment_method_two">
                                    <label for="payment_method_two" class="form-check-label">Stripe</label>
                                </div>
                                <div class="card-body p-0 d-none" id="card-payment-form">
                                    <div class="mb-3">
                                        <label for="card_number" class="mb-2">Número do Cartão</label>
                                        <input type="text" name="card_number" id="card_number"
                                            placeholder="Número do Cartão Válido" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="expiry_date" class="mb-2">Data de Validade</label>
                                            <input type="text" name="expiry_date" id="expiry_date"
                                                placeholder="MM/AAAA" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="expiry_date" class="mb-2">Código CVV</label>
                                            <input type="text" name="expiry_date" id="expiry_date" placeholder="123"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4">
                                    {{-- <a href="#" class="btn-dark btn btn-block w-100">Pagar Agora</a> --}}
                                    <button type="submit" class="btn-dark btn btn-block w-100">Pagar Agora</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

    </main>
@endsection
@section('add_scriptJs')
    <script>
        $("#payment_method_one").click(function() {
            if ($(this).is(":checked")) {
                $("#card-payment-form").addClass('d-none');
            }
        });
        $("#payment_method_two").click(function() {
            if ($(this).is(":checked")) {
                $("#card-payment-form").removeClass('d-none');
            }
        });
    </script>
    <script>
        $("#orderForm").submit(function(event) {
            event.preventDefault();
            var formArray = $(this).serializeArray();
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route('front.processCheckout') }}',
                type: 'post',
                data: formArray,
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    if (response['status'] == true) {
                        $(".error").removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='number']").removeClass('is-invalid');
                        window.location.href = "{{ url('thanks/') }}/" + response.orderId;
                    } else {
                        var errors = response['errors'];
                        $(".error").removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='number']").removeClass('is-invalid');
                        $.each(errors, function(key, value) {
                            $(`#${key}`).addClass('is-invalid').siblings('p')
                                .addClass('invalid-feedback')
                                .html(value);
                        });
                    }
                },
                error: function(jqXHR, exception) {
                    console.log("something went wrong");
                }
            });
        });
    </script>
    
    <script>
        $("#country").change(function() {
            $.ajax({
                url: '{{ route('front.getOrderSummery') }}', // Verifique se esta rota está definida corretamente em seu aplicativo
                type: 'post',
                data: {
                    country_id: $(this).val()
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        $('#shippingAmount').html(response.shippingCharge +
                        ' AOA'); // Adicione aspas em torno dos seletores
                        $('#grandTotal').html(response.grandTotal +
                        ' AOA'); // Adicione aspas em torno dos seletores
                        $('#discount-response-wrapper').html(response.discountString);
                        
                    }
                }
            });
        });
    </script>
    <script>
        $("#apply_coupon").click(function() {
            $.ajax({
                url: '{{ route('front.applyDiscount') }}', // Verifique se esta rota está definida corretamente em seu aplicativo
                type: 'post',
                data: {
                    code: $("#discount_code").val(),
                    country_id: $("#country").val()
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status== true) {
                        
                        $('#shippingAmount').html(response.shippingCharge +
                        ' AOA'); // Adicione aspas em torno dos seletores
                        $('#grandTotal').html(response.grandTotal +
                        ' AOA'); // Adicione aspas em torno dos seletores
                        $('#discount_value').html(response.discount +
                        ' AOA'); // Adicione aspas em torno dos seletores
                        $('#discount-response-wrapper').html(response.discountString);
                        
                    }else{
                        $('#discount-response-wrapper').html("<span class ='text-danger'> "+response.message+"</span>");
                    }
                }
            });
        });
    </script>
        <script>
            $('body').on('click',"#remove-discount",function(){
                $.ajax({
                    url: '{{ route('front.removeCoupon') }}', // Verifique se esta rota está definida corretamente em seu aplicativo
                    type: 'post',
                    data: {
                        country_id: $("#country").val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status== true) {
                            
                            $('#shippingAmount').html(response.shippingCharge +
                            ' AOA'); // Adicione aspas em torno dos seletores
                            $('#grandTotal').html(response.grandTotal +
                            ' AOA'); // Adicione aspas em torno dos seletores
                            $('#discount_value').html(response.discount +
                            ' AOA'); // Adicione aspas em torno dos seletores
                            $('#discount-response').html('');
                            $("#discount_code").val('');
                            
                        }
                    }
                });
            });
            // $("#remove-discount").click(function() {

            // });
        </script>
@endsection
