@extends('admin.layouts.app')
@section('main_content')
    <div class="pagetitle">
        <h1> Editar Marca</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('brands.index') }}">Marca</a></li>
                <li class="breadcrumb-item active">Editar Marca</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header p-2">
            <div class="card-tools">
                <a class="btn btn-primary float-end" href="{{ route('brands.index') }}"><i class="bi bi-arrow-left-circle me-1"></i>Voltar</a>
            </div>
        </div>
        <div class="card-body mt-2 ">
            <!-- Custom Styled Validation -->
            <form action='' method="POST" id="brandForm" name="brandForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Nome</label>
                            <input type="text"  value="{{$brand->name}}" name="name" id="name" class="form-control" placeholder="Nome">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" readonly disabled value="{{$brand->slug}}" name="slug"  id="slug"
                                class="form-control bg-body-secondary" placeholder="Nome alternativo">
                                <input type="hidden" value="{{$brand->slug}}" name="slug" readonly id="slug"
                                class="form-control bg-body-secondary" placeholder="Nome alternativo">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option {{ $brand->status == 1 ? 'selected':''}} value="1">Activo</option>
                                <option {{ $brand->status == 0 ? 'selected':''}} value="0">Bloqueado</option>
                            </select>
                        </div>
                    </div>
                <div class="card-footer p-2">
                    <button type="submit" class="btn btn-primary"><i class="ri-save-2-line me-1 "></i>Editar</button>
                    <a href="{{ route('brands.index') }}" class="btn btn-outline-dark ml-3"><i class="bi bi-x-circle me-1 "></i>Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script_add')
    <script>
        // Função executada quando o formulário com o ID "brandForm" é enviado
        $("#brandForm").submit(function(event) {
            // Impede o envio padrão do formulário
            event.preventDefault();
            $("button[type=submit]").prop('disabled', true)
            // Captura o elemento do formulário
            var element = $(this);

            // Requisição AJAX para enviar os dados do formulário para a rota 'categories.store'
            $.ajax({
                url: '{{ route('brands.update',$brand->id) }}',
                type: 'put',
                data: element.serializeArray(), // Serializa os dados do formulário
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    // Verifica se a resposta indica sucesso
                    if (response['status'] == true) {
                        window.location.href = "{{ route('brands.index') }}"
                        // Remove quaisquer classes de validação e mensagens de erro para o campo 'name'
                        $("#name").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html("");
                        // Remove quaisquer classes de validação e mensagens de erro para o campo 'slug'
                        $("#slug").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html("");
                    } else {
                        if (response['notFound'] == true) {
                        window.location.href = "{{ route('brands.index') }}"
                            
                        }
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
                            $("#slug").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors['slug']);
                        } else {
                            // Remove classes de erro e mensagem de erro para o campo 'slug'
                            $("#slug").removeClass('is-invalid').siblings('p').removeClass(
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
                        $("#slug").val(response["slug"]);
                    }
                }
            });
        });


    </script>
@endsection
