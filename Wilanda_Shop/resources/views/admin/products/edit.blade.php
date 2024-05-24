@extends('admin.layouts.app')
@section('main_content')
    <div class="pagetitle">
        <h1> Editar Produto</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produto</a></li>
                <li class="breadcrumb-item active">Editar Produto</li>
            </ol>
        </nav>
    </div>
    <section>
        <!-- Form Editar Produto -->
        <form action="" method="post" name="productForm" id="productForm">
            <div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 pt-2 ">
                                        <div class="mb-3">
                                            <label for="title">Título</label>
                                            <input type="text" name="title" id="title" class="form-control"
                                                placeholder="Título" value="{{ $product->title }}">
                                            <p class="error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input type="text" readonly disabled name="slug" id="slug"
                                                class="form-control" placeholder="Nome Alternativo"
                                                value="{{ $product->slug }}">
                                                <input type="hidden" name="slug" id="slug"
                                                class="form-control" placeholder="Nome Alternativo"
                                                value="{{ $product->slug }}">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="short_description">Pequena descrição</label>
                                            <!-- Editor TinyMCE -->
                                            <textarea class="summernote" name="short_description" id="short_description" cols="20" rows="10">
                                                {{ $product->short_description }}
                                        </textarea><!-- Fim do Editor TinyMCE -->
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Descrição</label>
                                            <!-- Editor TinyMCE -->
                            
                                            <textarea class="summernote" name="description" id="description" cols="20" rows="10">
                                                {{ $product->description }}
                                            </textarea><!-- Fim do Editor TinyMCE -->
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="shipping_returns">Envio & Devoluções</label>
                                            <!-- Editor TinyMCE -->
                                            <textarea class="summernote" name="shipping_returns" id="shipping_returns" cols="20" rows="10">
                                                {{ $product->shipping_returns }}
                                        </textarea><!-- Fim do Editor TinyMCE -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body  ">
                                <h2 class="h4 mb-3 mt-3">Mídia</h2>
                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Arraste os arquivos aqui ou clique para fazer o upload.<br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="product-gallery">
                            @if ($productImage->isNotEmpty())
                                @foreach ($productImage as $product_Image)
                                    <div class="col-md-3 mb-2" id="image-row-{{ $product_Image->id }}">
                                        <input type="hidden" name="image_array[]" value="{{ $product_Image->id }}">
                                        <div class="card p-0">
                                            <img src="{{ asset('uploads/product/small/' . $product_Image->image) }}"
                                                class="card-img-top" alt="...">
                                            <div class="card-body p-0 my-2 ms-1">
                                                <a href="javascript:void(0)"
                                                    onclick="deleteImage({{ $product_Image->id }})"
                                                    class="btn btn-danger">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="card mb-3">
                            <div class="card-body ">
                                <h2 class="h4 mb-3 mt-3">Preços</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Preço</label>
                                            <input type="text" name="price" id="price" class="form-control"
                                                placeholder="Preço" value="{{ $product->price }}">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Preço de Comparação</label>
                                            <input type="text" name="compare_price" id="compare_price"
                                                class="form-control" placeholder="Preço de Comparação"
                                                value="{{ $product->compare_price }}">
                                            <p class="text-muted mt-3">
                                                Para exibir um preço reduzido, mova o preço original do produto para o campo
                                                de Preço de Comparação. Insira um valor menor no campo de Preço.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3 mt-3">Inventário</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Unidade de Manutenção de Estoque)</label>
                                            <input type="text" name="sku" id="sku" class="form-control"
                                                placeholder="SKU" value="{{ $product->sku }}">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Código de Barras</label>
                                            <input type="text" name="barcode" id="barcode" class="form-control"
                                                placeholder="Código de Barras" value="{{ $product->barcode }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" name="track_qty" id="track_qty" value="No">
                                                <input class="form-check-input" type="checkbox" id="track_qty"
                                                    name="track_qty" value="Yes" checked="">
                                                <label for="track_qty" class="custom-control-label">Rastrear
                                                    Quantidade</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="qty" id="qty"
                                                class="form-control" placeholder="Quantidade"
                                                value="{{ $product->qty }}">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3 mt-3">Status do Produto</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-select">
                                        <option {{ $product->status == 1 ? 'selected' : '' }} value="1">Ativo
                                        </option>
                                        <option {{ $product->status == 0 ? 'selected' : '' }} value="0">Bloqueado
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3 mt-3 ">Categoria do Produto</h2>
                                <div class="mb-3">
                                    <label for="category">Categoria</label>
                                    <select name="category" id="category" class="form-select">
                                        <option value="">Selecione a Categoria</option>
                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option {{ $product->category_id == $category->id ? 'selected' : '' }}
                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                                <div class="mb-3">
                                    <label for="category">Subcategoria</label>
                                    <select name="sub_category" id="sub_category" class="form-select">
                                        <option value="">Selecione a Subcategoria</option>
                                        @if ($subCategories->isNotEmpty())
                                            @foreach ($subCategories as $subCategory)
                                                <option
                                                    {{ $product->sub_category_id == $subCategory->id ? 'selected' : '' }}
                                                    value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3 mt-3">Marca do Produto</h2>
                                <div class="mb-3">
                                    <select name="brand_id" id="brand_id" class="form-select">
                                        <option value="">Selecione a Marca</option>
                                        @if ($brands->isNotEmpty())
                                            @foreach ($brands as $brand)
                                                <option {{ $product->brand_id == $brand->id ? 'selected' : '' }}
                                                    value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3 mt-3">Produto em Destaque</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-select">
                                        <option {{ $product->is_featured == 'Não' ? 'selected' : '' }} value="No">Não
                                        </option>
                                        <option {{ $product->is_featured == 'Sim' ? 'selected' : '' }} value="Yes">Sim
                                        </option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3 mt-3">Podutos Relacionados</h2>
                                <div class="mb-3">
                                    <select multiple class="related-product w-100" name="related_products[]" id="related_products">
                                        @if (!empty($relatedProducts))
                                        @foreach ($relatedProducts as $relatedProduct)
                                            <option selected value="{{ $relatedProduct->id }}">{{ $relatedProduct->title }}</option>
                                        @endforeach
                                    @endif
                                    </select>

                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Editar</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Cancelar</a>
                </div>
            </div>
        </form>

        <!-- /.card -->
    </section>
@endsection
@section('script_add')
    <script>
        $(document).ready(function() {
            $('.related-product').select2({
            ajax: {
                url: '{{ route('products.getProducts') }}',
                dataType: 'json',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function(data) {
                    return {
                        results: data.tags
                    };
                }
            }
        });
});

       
    </script>
    <script>
        // Função executada quando o campo com o ID "title" é alterado
        $("#title").change(function() {
            // Captura o elemento do campo 'name'
            var element = $(this);
            $("button[type=submit]").prop('disabled', true)
            // Requisição AJAX para obter o slug com base no título fornecido
            $.ajax({
                url: '{{ route('getSlug') }}',
                type: 'get',
                data: {
                    title: element.val()
                },
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    // Se a resposta indicar sucesso, atualiza o valor do campo 'slug' com o valor retornado
                    if (response["status"] == true) {
                        $("#slug").val(response["slug"]);
                    }
                }
            });
        });
    </script>
    <script>
        $("#productForm").submit(function(event) {
            event.preventDefault();
            var formArray = $(this).serializeArray();
            $("button[type=submit]").prop('disabled', true)
            $.ajax({
                url: '{{ route('product.update', $product->id) }}',
                type: 'put',
                data: formArray,
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    if (response['status'] == true) {
                        $(".error").removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='number']").removeClass('is-invalid');
                        window.location.href = "{{ route('products.index') }}"

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
        $("#category").change(function() {

            var category_id = $(this).val();

            $.ajax({
                url: '{{ route('product-subCategories.index') }}',
                type: 'get',
                data: {
                    category_id: category_id
                },
                dataType: 'json',
                success: function(response) {
                    $("#sub_category").find("option").not(":first").remove();
                    $.each(response["subCategories"], function(key, item) {
                        $("#sub_category").append(
                            `<option value='${item.id}'>${item.name}</option>`);
                    });
                },
                error: function(jqXHR, exception) {
                    // Se ocorrer um erro na requisição, exibe uma mensagem de erro no console
                    console.log("something went wrong");
                }
            });

        });
    </script>
    <script>
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            url: "{{ route('product-image.update') }}",
            maxFiles: 10,
            paramName: 'image',
            params: {
                'product_id': '{{ $product->id }}'
            },
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                var html = `<div class="col-md-3 mb-3" id="image-row-${response.image_id}">
                                <input type="hidden" name="image_array[]" value="${response.image_id}">
                                <div class="card p-0">
                                    <img src="${response.ImagePath}" class="card-img-top" alt="...">
                                    <div class="card-body p-0 my-2 ms-1">
                                        <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Eliminar</a>
                                    </div>
                                    </div>
                            </div>`;

                $("#product-gallery").append(html);

            },
            complete: function(file) {
                this.removeFile(file);
            }

        });

        function deleteImage(id) {
            $("#image-row-" + id).remove();
            if (confirm("Are you sure you want to delete image?")) {
                $.ajax({
                    url: '{{ route('product-image.delete') }}',
                    type: 'delete',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.status == true) {
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }
        }
    </script>
@endsection
