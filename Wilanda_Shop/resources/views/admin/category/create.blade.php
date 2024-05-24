@extends('admin.layouts.app')
@section('main_content')
    <div class="pagetitle">
        <h1> Nova Categória</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categória</a></li>
                <li class="breadcrumb-item active">Nova Categória</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header p-2">
            <div class="card-tools">
                <a class="btn btn-primary float-end" href="{{ route('categories.index') }}"><i class="bi bi-arrow-left-circle me-1"></i>Voltar</a>
            </div>
        </div>
        <div class="card-body mt-2 ">
            <!-- Custom Styled Validation -->
            <form action='' method="POST" id="categoryForm" name="categoryForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Nome</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nome">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug1" readonly disabled id="slug1"
                                class="form-control bg-body-secondary" placeholder="Nome alternativo">
                                <input type="hidden" name="slug" readonly id="slug"
                                class="form-control bg-body-secondary" placeholder="Nome alternativo">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="1">Activo</option>
                                <option value="0">Bloqueado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="showHome">Show Home</label>
                            <select name="showHome" id="showHome" class="form-select">
                                <option value="No">Não</option>
                                <option value="Yes">Sim</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <input type="hidden" id="image_id" name="image_id" value="">
                            <label for="image">Image</label>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br>Drop files here or click to upload.<br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2">
                    <button type="submit" class="btn btn-primary"><i class="ri-save-2-line me-1 "></i>Guardar</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-dark "><i class="bi bi-x-circle me-1 "></i>Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script_add')
    <script>
        // Função executada quando o formulário com o ID "categoryForm" é enviado
        $("#categoryForm").submit(function(event) {
            // Impede o envio padrão do formulário
            event.preventDefault();
            $("button[type=submit]").prop('disabled', true)
            // Captura o elemento do formulário
            var element = $(this);

            // Requisição AJAX para enviar os dados do formulário para a rota 'categories.store'
            $.ajax({
                url: '{{ route('categories.store') }}',
                type: 'post',
                data: element.serializeArray(), // Serializa os dados do formulário
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    // Verifica se a resposta indica sucesso
                    if (response['status'] == true) {
                        window.location.href = "{{ route('categories.index') }}"
                        // Remove quaisquer classes de validação e mensagens de erro para o campo 'name'
                        $("#name").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html("");
                        // Remove quaisquer classes de validação e mensagens de erro para o campo 'slug'
                        $("#slug1").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html("");
                    } else {
                        // Caso haja erros na resposta, captura os erros
                        var errors = response['errors'];
                        // Verifica se há erro no campo 'name'
                        if (errors['name']) {
                            // Adiciona classe de erro e exibe a mensagem de erro para o campo 'name'
                            $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors['name']);
                        } else {
                            // Remove classes de erro e mensagem de erro para o campo 'name'
                            $("#name").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html("");
                        }

                        // Verifica se há erro no campo 'slug'
                        if (errors['slug']) {
                            // Adiciona classe de erro e exibe a mensagem de erro para o campo 'slug'
                            $("#slug1").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors['slug']);
                        } else {
                            // Remove classes de erro e mensagem de erro para o campo 'slug'
                            $("#slug1").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html("");
                        }
                    }
                },
                error: function(jqXHR, exception) {
                    // Se ocorrer um erro na requisição, exibe uma mensagem de erro no console
                    console.log("something went wrong");
                }
            });
        });

        // Função executada quando o campo com o ID "name" é alterado
        $("#name").change(function() {
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
                        $("#slug1").val(response["slug"]);
                        $("#slug").val(response["slug"]);
                    }
                }
            });
        });

        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url: "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                $("#image_id").val(response.image_id);
                //console.log(response)
            }
        });
    </script>
@endsection
