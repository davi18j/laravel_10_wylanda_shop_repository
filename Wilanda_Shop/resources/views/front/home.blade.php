@extends('front.layout.app')
@section('main_Shop')
    <main>
        <section class="section-1">
            <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel"
                data-bs-interval="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <picture>
                            <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/carousel-1.jpg')}}" />
                            <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/carousel-1.jpg')}}" />
                            <img src="{{asset('front-assets/images/carousel-1.jpg')}}" alt="" />
                        </picture>

                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3">
                                {{-- <h1 class="display-4 text-white mb-3">Moda Infantil</h1>
                                <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet
                                    amet amet ndiam elitr ipsum diam</p> --}}
                                <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{route('front.shop')}}">Compre Agora</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">

                        <picture>
                            <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/carousel-2.jpg')}}" />
                            <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/carousel-2.jpg')}}" />
                            <img src="{{asset('front-assets/images/carousel-2.jpg')}}" alt="" />
                        </picture>

                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3">
                                {{-- <h1 class="display-4 text-white mb-3">Moda Feminina</h1>
                                <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet
                                    amet amet ndiam elitr ipsum diam</p> --}}
                                <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{route('front.shop')}}">Compre Agora</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                    

                        <picture>
                            <source media="(max-width: 799px)" srcset="{{asset('front-assets/images/carousel-3.jpg')}}" />
                            <source media="(min-width: 800px)" srcset="{{asset('front-assets/images/carousel-3.jpg')}}" />
                            <img src="{{asset('front-assets/images/carousel-3.jpg')}}" alt="" />
                        </picture>

                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3">
                                {{-- <h1 class="display-4 text-white mb-3">Compre Online com 70% de Desconto em Roupas de Marca
                                </h1>
                                <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet
                                    amet amet ndiam elitr ipsum diam</p> --}}
                                <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{route('front.shop')}}">Compre Agora</a>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>
        </section>

        <section class="section-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">Produto de Qualidade</h2>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">Frete Grátis</h2>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">Devolução em 14 Dias</h2>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">Suporte 24/7</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-3">
            <div class="container">
                <div class="section-title">
                    <h2>Categorias</h2>
                </div>
                <div class="row pb-3">
                    @if (getCategories()->isNotEmpty())
                        @foreach (getCategories() as $category)
                            <div class="col-lg-3">
                                <div class="cat-card">
                                    <div class="left">
                                        @if ($category->image != '')
                                            <img src="{{ asset('uploads/category/thumb/' . $category->image) }} "
                                                alt="" class="img-fluid">
                                        @endif
                                    </div>
                                    <div class="right">
                                        <div class="cat-data">
                                            <h2> {{ $category->name }} </h2>
                                            {{--   <p>100 Produtos</p> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
   @if ($featuredProducts->isNotEmpty())
        <section class="section-4 pt-5">
            <div class="container">
                <div class="section-title">
                    <h2>Produtos em Destaque</h2>
                </div>
                <div class="row pb-3">
                 
                        @foreach ($featuredProducts as $product)
                            @php
                                $productImage = $product->product_image->first();
                            @endphp
                            <div class="col-md-3">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="{{route('front.product',$product->slug)}}" class="product-img">
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
                                            <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$product->id}});" >
                                                <i class="fa fa-shopping-cart"></i> Adicionar ao Carrinho
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link" href="{{route('front.product',$product->slug)}}">{{ $product->title }}</a>
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
                            </div>
                        @endforeach
                </div>
            </div>
        </section>    
         @endif
        @if ($latestProducts->isNotEmpty())
        <section class="section-4 pt-5">
            <div class="container">
                <div class="section-title">
                    <h2>Últimos Produtos</h2>
                </div>
                <div class="row pb-3">
                
                        @foreach ($latestProducts as $product)
                            @php
                                $productImage = $product->product_image->first();
                            @endphp
                            <div class="col-md-3">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="{{route('front.product',$product->slug)}}" class="product-img">
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
                                            <a class="btn btn-dark" href="javascript:void(0)" onclick="addToCart({{$product->id}});" >
                                                <i class="fa fa-shopping-cart"></i> Adicionar ao Carrinho
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link" href="{{route('front.product',$product->slug)}}">{{ $product->title }}</a>
                                        <div class="price mt-2">
                                            <span class="h5"><strong>{{ number_format($product->price,2) }} AOA</strong></span>
                                            @if ($product->compare_price > 0)
                                                <span
                                                    class="h6 text-underline"><del class="text-danger">{{ number_format($product->compare_price,2) }} AOA</del></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach 
                </div>
            </div>
        </section>
        @endif
    </main>
@endsection

