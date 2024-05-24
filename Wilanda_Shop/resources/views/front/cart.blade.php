@extends('front.layout.app')
@section('main_Shop')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Início</a></li>
                        <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Loja</a></li>
                        <li class="breadcrumb-item">Carrinho</li>
                    </ol>
                </div>
            </div>
        </section>
        
        <section class=" section-9 pt-4">
            <div class="container">
                <div class="row">
                    @if (Session::has('success'))
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {!! Session::get('success') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @elseif (Session::has('error'))
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {!! Session::get('error') !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table" id="cart">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Preço</th>
                                        <th>Quantidade</th>
                                        <th>Total</th>
                                        <th>Remover</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (Cart::count()> 0)
                                        @foreach ($cartContnt as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-start">
                                                        @if (!empty($item->options->productImage->image))
                                                            <img src="{{ asset('uploads/product/small/' . $item->options->productImage->image) }}">
                                                        @else
                                                            <img src="{{ asset('uploads/product/default/default-150x150.png') }}">
                                                        @endif
                                                        <h2>{{ $item->name }}</h2>
                                                    </div>
                                                </td>
                                                <td>{{ $item->price }} AOA</td>
                                                <td>
                                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 sub"
                                                                data-id="{{ $item->rowId }}">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm  border-0 text-center"
                                                            value="{{ $item->qty }}">
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 add"
                                                                data-id="{{ $item->rowId }}">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $item->price * $item->qty }} AOA
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger" onclick="deleteItem('{{ $item->rowId }}');">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">O seu carrinho está vazio, adicione produtos</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card cart-summery">
                            <div class="sub-title">
                                <h2 class="bg-white">Resumo do Carrinho</h2>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between pb-2">
                                    <div>Subtotal</div>
                                    <div>{{ Cart::subtotal() }} AOA</div>
                                </div>
                                <div class="d-flex justify-content-between pb-2">
                                    <div>Envio</div>
                                    <div>0 AOA</div>
                                </div>
                                <div class="d-flex justify-content-between summery-end">
                                    <div>Total</div>
                                    <div>{{ Cart::subtotal() }} AOA</div>
                                </div>
                                <div class="pt-5">
                                    <a href="{{route('front.checkout')}}" class="btn-dark btn btn-block w-100">Prosseguir para o Checkout</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                </div>
            </div>
        </section>
    </main>
@endsection
@section('add_scriptJs')
    <script>
        $('.add').click(function() {
            var qtyElement = $(this).parent().prev(); // Qty Input
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue < 10) {
                qtyElement.val(qtyValue + 1);
                var rowId = $(this).data('id');
                var newQty = qtyElement.val();
                updateCart(rowId, newQty)
            }
        });

        $('.sub').click(function() {
            var qtyElement = $(this).parent().next();
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue > 1) {
                qtyElement.val(qtyValue - 1);
                var rowId = $(this).data('id');
                var newQty = qtyElement.val();
                updateCart(rowId, newQty)
            }
        });

        function updateCart(rowId, qty) {
            $.ajax({
                url: '{{ route('front.updateCart') }}',
                type: 'post',
                data: {
                    rowId: rowId,
                    qty: qty
                },
                dataType: 'json',
                success: function(response) {

                    window.location.href = '{{ route('front.cart') }}';

                }
            });
        }

        function deleteItem(rowId) {
            if (confirm("Are you sure you want to delete?")) {
                $.ajax({
                    url: '{{ route('front.deleteItem.cart') }}',
                    type: 'post',
                    data: {
                        rowId: rowId
                    },
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = '{{ route('front.cart') }}';
                    }
                });
            }
        }
    </script>
@endsection
