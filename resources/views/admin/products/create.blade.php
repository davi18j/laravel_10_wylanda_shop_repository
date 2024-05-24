@extends('admin.layouts.app')
@section('main_content')
    <div class="pagetitle">
        <h1> Novo Produto</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produto</a></li>
                <li class="breadcrumb-item active">Novo Produto</li>
            </ol>
        </nav>
    </div>
    <section>
        <!-- Form Produtos -->
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
                                                placeholder="Título">
                                            <p class="error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug1">Slug</label>
                                            <input type="text" readonly disabled name="slug1"  id="slug1"
                                                class="form-control" placeholder="nome alternativo">
                                                <input type="hidden" readonly name="slug"  id="slug"
                                                class="form-control" placeholder="nome alternativo">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="short_description">Pequena descrição</label>
                                            <!-- Editor TinyMCE -->
                                            <textarea class="summernote" name="short_description" id="short_description" >
                                        </textarea><!-- Fim do Editor TinyMCE -->
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Descrição</label>
                                            <!-- Editor TinyMCE -->
                                            <textarea class="summernote" name="description" id="description" cols="20" rows="10">
                                        </textarea><!-- Fim do Editor TinyMCE -->
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="shipping_returns">Envio & Devoluções</label>
                                            <!-- Editor TinyMCE -->
                                            <textarea class="summernote" name="shipping_returns" id="shipping_returns" cols="20" rows="10">
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
                                        <br>Arraste os arquivos aqui ou clique para fazer upload.<br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="product-gallery">

                        </div>
                        <div class="card mb-3">
                            <div class="card-body ">
                                <h2 class="h4 mb-3 mt-3">Preços</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Preço</label>
                                            <input type="text" name="price" id="price" class="form-control"
                                                placeholder="Preço">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Preço de comparação</label>
                                            <input type="text" name="compare_price" id="compare_price"
                                                class="form-control" placeholder="Preço de comparação">
                                            <p class="text-muted mt-3">
                                                Para mostrar um preço reduzido, mova o preço original do produto para o
                                                campo de preço de comparação. Insira um valor menor no campo de preço.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3 mt-3">Estoque</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Unidade de Manutenção de Estoque)</label>
                                            <input type="text" name="sku" id="sku" class="form-control"
                                                placeholder="sku">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Código de barras</label>
                                            <input type="text" name="barcode" id="barcode" class="form-control"
                                                placeholder="Código de barras">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" name="track_qty" id="track_qty" value="No">
                                                <input class="form-check-input" type="checkbox" id="track_qty"
                                                    name="track_qty" value="Yes" checked="">
                                                <label for="track_qty" class="custom-control-label">Rastrear
                                                    quantidade</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="qty" id="qty"
                                                class="form-control" placeholder="Quantidade">
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
                                <h2 class="h4 mb-3 mt-3">Status do produto</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-select">
                                        <option value="1">Ativo</option>
                                        <option value="0">Bloqueado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3 mt-3 ">Categoria do produto</h2>
                                <div class="mb-3">
                                    <label for="category">Categoria</label>
                                    <select name="category" id="category" class="form-select">
                                        <option value="">Selecione a Categoria</option>
                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                                <div class="mb-3">
                                    <label for="category">Subcategoria</label>
                                    <select name="sub_category" id="sub_category" class="form-select">
                                        <option value=""> Selecione a Subcategoria</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3 mt-3">Marca do produto</h2>
                                <div class="mb-3">
                                    <select name="brand_id" id="brand_id" class="form-select">
                                        <option value="">Selecione a Marca</option>
                                        @if ($brands->isNotEmpty())
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3 mt-3">Produto em destaque</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-select">
                                        <option value="No">Não</option>
                                        <option value="Yes">Sim</option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Criar</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Cancelar</a>
                </div>
            </div>
        </form>
        <!-- / .card -->

    </section>
@endsection
@section('script_add')
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
                        $("#slug1").val(response["slug"]);
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
                url: '{{ route('products.store') }}',
                type: 'post',
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
            url: "{{ route('temp-images.create') }}",
            maxFiles: 10,
            paramName: 'image',
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
        }
    </script>
{{--     <script>
// Função para gerar SKU com base no título do produto
function gerarSKU() {
    // Obter o valor do título e converter para maiúsculas
    const titulo = document.getElementById('title').value.toUpperCase();

    // Remover caracteres especiais e de pontuação
    let nomeFormatado = titulo.replace(/[^\w\s]/gi, '');

    // Substituir espaços por hífens
    nomeFormatado = nomeFormatado.replace(/\s+/g, '-');

    // Contar o número de caracteres no título
    const numCaracteres = nomeFormatado.length;

    // Gerar o sufixo numérico com base no número de caracteres
    let sufixoNumerico = ('000' + numCaracteres).slice(-3);

    // Verificar se o sufixo numérico já foi utilizado anteriormente
    let numerosUtilizados = JSON.parse(localStorage.getItem('numerosUtilizados')) || {};
    if (numerosUtilizados.hasOwnProperty(sufixoNumerico)) {
        // Incrementar o sufixo numérico até encontrar um não utilizado
        let novoSufixoNumerico = parseInt(sufixoNumerico);
        do {
            novoSufixoNumerico++;
            sufixoNumerico = ('000' + novoSufixoNumerico).slice(-3);
        } while (numerosUtilizados.hasOwnProperty(sufixoNumerico));
    }

    // Armazenar o sufixo numérico utilizado
    numerosUtilizados[sufixoNumerico] = true;
    localStorage.setItem('numerosUtilizados', JSON.stringify(numerosUtilizados));

    // Gerar o SKU personalizado
    let SKU = nomeFormatado.slice(0, 4) + '-' + sufixoNumerico + '-WL-' + Math.floor(Math.random() * 1000);

    // Atualizar o valor do campo de SKU
    document.getElementById('sku').value = SKU;
}

// Associar a função gerarSKU ao evento de mudança no campo de título
document.getElementById('title').addEventListener('input', gerarSKU);

// Chamar a função uma vez para gerar o SKU inicial ao carregar a página
gerarSKU();


    </script> --}}
@endsection
