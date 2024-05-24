@extends('admin.layouts.app')
@section('main_content')
    <div class="pagetitle">
        <h1> Editar Sub Categória</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sub-categories.index') }}">Sub Categória</a></li>
                <li class="breadcrumb-item active">Nova Sub Categória</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header p-2">
            <div class="card-tools">
                <a class="btn btn-primary float-end" href="{{ route('sub-categories.index') }}"><i class="bi bi-arrow-left-circle me-1"></i>Voltar</a>
            </div>
        </div>
        <div class="card-body mt-2 ">
            <form action='' method="POST" id="subcategoryForm" name="subcategoryForm">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name">Categoria</label>
                            <select name="category" id="category" class="form-select">
                            <option value="" selected=""> selecione a categoria</option>
                                @if ($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                        <option {{$subCategory->category_id == $category->id ? 'selected': ''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Nome</label>
                            <input type="text" value="{{$subCategory->name}}" name="name" id="name" class="form-control" placeholder="Nome">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" value="{{$subCategory->slug}}" name="slug" readonly disabled id="slug"
                                class="form-control bg-body-secondary" placeholder="Nome alternativo">
                                <input type="hidden" value="{{$subCategory->slug}}" name="slug" readonly id="slug"
                                class="form-control bg-body-secondary" placeholder="Nome alternativo">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option  {{$subCategory->status == 1 ? 'selected':''}} value="1">Activo</option>
                                <option {{$subCategory->status == 0 ? 'selected':''}} value="0">Bloqueado</option>
                            </select>
                            <p></p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="showHome">Show Home</label>
                                <select name="showHome" id="showHome" class="form-select">
                                    <option  {{$subCategory->showHome == 'No' ? 'selected':''}} value="No">Não</option>
                                    <option {{$subCategory->showHome == 'Yes' ? 'selected':''}} value="Yes">Sim</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <button type="submit" class="btn btn-primary"><i class="ri-save-2-line me-1 "></i>Editar</button>
                        <a href="{{route('sub-categories.index')}}" class="btn btn-outline-dark"><i class="bi bi-x-circle me-1 "></i>Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    @endsection
    @section('script_add')
        <script>
            // Função executada quando o formulário com o ID "subcategoryForm" é enviado
            $("#subcategoryForm").submit(function(event) {
                // Impede o envio padrão do formulário
                event.preventDefault();
                $("button[type=submit]").prop('disabled', true)
                // Captura o elemento do formulário
                var element = $("#subcategoryForm");

                // Requisição AJAX para enviar os dados do formulário para a rota 'categories.store'
                $.ajax({
                    url: '{{ route('sub-categories.update',$subCategory->id) }}',
                    type: 'put',
                    data: element.serializeArray(), // Serializa os dados do formulário
                    dataType: 'json',
                    success: function(response) {
                        $("button[type=submit]").prop('disabled', false)
                        // Verifica se a resposta indica sucesso
                        if (response['status'] == true) {
                             window.location.href = "{{ route('sub-categories.index') }}"
                            // // Remove quaisquer classes de validação e mensagens de erro para o campo 'name'
                             $("#name").removeClass('is-invalid').siblings('p').removeClass(
                                 'invalid-feedback').html("");
                             // Remove quaisquer classes de validação e mensagens de erro para o campo 'slug'
                             $("#slug").removeClass('is-invalid').siblings('p').removeClass(
                                 'invalid-feedback').html("");
                                  // Remove quaisquer classes de validação e mensagens de erro para o campo 'category'
                                 $("#category").removeClass('is-invalid').siblings('p').removeClass(
                                 'invalid-feedback').html("");
                        } else {
                            if (response['notFound']==true) {
                                window.location.href = "{{ route('sub-categories.index') }}"
                                return false;
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
                            
                            // Verifica se há erro no campo 'category'
                            if (errors['category']) {
                                // Adiciona classe de erro e exibe a mensagem de erro para o campo 'category'
                                $("#category").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                    .html(errors['category']);
                            } else {
                                // Remove classes de erro e mensagem de erro para o campo 'category'
                                $("#category").removeClass('is-invalid').siblings('p').removeClass(
                                    'invalid-feedback').html("");
                            }
                            // Verifica se há erro no campo 'status'
                            if (errors['status']) {
                                // Adiciona classe de erro e exibe a mensagem de erro para o campo 'status'
                                $("#status").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                    .html(errors['status']);
                            } else {
                                // Remove classes de erro e mensagem de erro para o campo 'status'
                                $("#status").removeClass('is-invalid').siblings('p').removeClass(
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
