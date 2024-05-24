@extends('front.layout.app')
@section('main_Shop')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Página Inicial</a>
                        </li>
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Loja</a></li>
                        <li class="breadcrumb-item">{{ $product->title }}</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-7 pt-3 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col-md-5">

                        <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">

                            <div class="carousel-inner bg-light">
                                @if ($product->product_image)
                                    @foreach ($product->product_image as $key => $product_image)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img class="w-100 h-100"
                                                src="{{ asset('uploads/product/large/' . $product_image->image) }}"
                                                alt="Imagem">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                                <i class="fa fa-2x fa-angle-left text-dark"></i>
                            </a>
                            <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                                <i class="fa fa-2x fa-angle-right text-dark"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="bg-light right">
                            <h1>{{ $product->title }}</h1>
                            <div class="d-flex mb-3">
                                <div class="text-primary mr-2">
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star-half-alt"></small>
                                    <small class="far fa-star"></small>
                                </div>
                                <small class="pt-1">(99 Avaliações)</small>
                            </div>
                            @if ($product->compare_price > 0)
                                <h5 class="text-secondary"><del class="text-danger"> {{ number_format($product->compare_price,2) }} AOA</del></h5>
                            @endif
                            <h2 class="price ">{{ number_format($product->price,2) }} AOA</h2>
                            <p>{!! $product->short_description !!}.</p>
                            <a href="javascript:void(0)" onclick="addToCart({{ $product->id }});" class="btn btn-dark"><i
                                    class="fas fa-shopping-cart"></i> &nbsp;ADICIONAR AO
                                CARRINHO</a>
                        </div>
                    </div>
                    <div class="col-md-12 mt-5">
                        <div class="bg-light">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                        data-bs-target="#description" type="button" role="tab"
                                        aria-controls="description" aria-selected="true">Descrição</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="shipping-tab" data-bs-toggle="tab"
                                        data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping"
                                        aria-selected="false"> Envio & Devoluções</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                        type="button" role="tab" aria-controls="reviews"
                                        aria-selected="false">Avaliações</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel"
                                    aria-labelledby="description-tab">
                                    <p>{!! $product->description !!}</p>
                                </div>
                                <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                    <p>{!! $product->shipping_returns !!}</p>
                                </div>
                                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        @if (!empty($relatedProducts))
            <section class="pt-5 section-8">
                <div class="container">
                    <div class="section-title">
                        <h2>Produtos Relacionados</h2>
                    </div>
                    <div class="col-md-12">
                        <div id="related-products" class="carousel">
                            @foreach ($relatedProducts as $relatedProduct)
                                @php
                                    $productImage = $relatedProduct->product_image->first();
                                @endphp
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="{{ route('front.product', $relatedProduct->slug) }}" class="product-img">
                                            @if (!empty($productImage->image))
                                                <img class="card-img-top"
                                                    src="{{ asset('uploads/product/small/' . $productImage->image) }}">
                                            @else
                                                <img class="card-img-top"
                                                    src="{{ asset('uploads/product/default/default-150x150.png') }}">
                                            @endif
                                        </a>
                                        <a class="whishlist" href="222"><i class="far fa-heart"></i></a>
                                        <div class="product-action">
                                            <a class="btn btn-dark" href="javascript:void(0)"
                                                onclick="addToCart({{ $product->id }});">
                                                <i class="fa fa-shopping-cart"></i> Adicionar ao Carrinho
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link"
                                            href="{{ route('front.product', $relatedProduct->slug) }}">{{ $relatedProduct->title }}</a>
                                            <div class="price mt-2">
                                                <div class="row">
                                                    @if ($product->compare_price > 0)
                                                        <span class="h6 text-underline mb-1 "><del
                                                                class="text-danger">{{ number_format($product->compare_price, 2) }}
                                                                AOA</del></span>
                                                    @endif
                                                    <span class="h5"><strong>{{ number_format($product->price, 2) }}
                                                            AOA</strong></span>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- Repita este bloco para cada produto relacionado -->
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>
@endsection
@section('add_scriptJs')
@endsection