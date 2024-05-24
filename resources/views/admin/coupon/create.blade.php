@extends('admin.layouts.app')
@section('main_content')
    <div class="pagetitle">
        <h1> Nova Categória</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('discount.index') }}">Categória</a></li>
                <li class="breadcrumb-item active">Nova Categória</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header p-2">
            <div class="card-tools">
                <a class="btn btn-primary float-end" href="{{ route('discount.index') }}"><i
                        class="bi bi-arrow-left-circle me-1"></i>Voltar</a>
            </div>
        </div>
        <div class="card-body mt-2 ">
            <!-- Custom Styled Validation -->
            <form action='' method="POST" id="couponForm" name="couponForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="code" class="form-label">Código</label>
                            <input type="text" class="form-control" id="code" name="code">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="max_uses" class="form-label">Máximo de Usos</label>
                            <input type="number" min="0"  class="form-control" id="max_uses" name="max_uses">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="max_uses_user" class="form-label">Máximo de Usos por Usuário</label>
                            <input type="number" min="0"  class="form-control" id="max_uses_user" name="max_uses_user">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="discount_amount" class="form-label">Valor do Desconto</label>
                            <input type="number" min="0" class="form-control" id="discount_amount"
                                name="discount_amount">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label">Tipo</label>
                            <select class="form-select" id="type" name="type">
                                <option value="percent">Percentual</option>
                                <option value="fixed">Fixo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="min_amount" class="form-label">Valor Mínimo</label>
                            <input type="number" min="0" class="form-control" id="min_amount" name="min_amount">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="starts_at" class="form-label">Início</label>
                            <input type="text" class="form-control" id="starts_at" name="starts_at">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="expires_at" class="form-label">Expira em</label>
                            <input type="text" class="form-control" id="expires_at" name="expires_at">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <textarea class="form-control" style="height: 100px" placeholder="Descrição"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2">
                    <button type="submit" class="btn btn-primary"><i class="ri-save-2-line me-1"></i>Salvar</button>
                    <a href="{{ route('discount.index') }}" class="btn btn-outline-dark"><i
                            class="bi bi-x-circle me-1"></i>Cancelar</a>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('script_add')
    <script>
        // Função executada quando o formulário com o ID "couponForm" é enviado
        $("#couponForm").submit(function(event) {
            // Impede o envio padrão do formulário
            event.preventDefault();
            $("button[type=submit]").prop('disabled', true)
            // Captura o elemento do formulário
            var element = $(this);

            // Requisição AJAX para enviar os dados do formulário para a rota 'categories.store'
            $.ajax({
                url: '{{ route('discount.store') }}',
                type: 'post',
                data: element.serializeArray(), // Serializa os dados do formulário
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    // Verifica se a resposta indica sucesso
                    if (response['status'] == true) {
                         window.location.href = "{{ route('discount.index') }}"
                        // Remove quaisquer classes de validação e mensagens de erro para o campo 'code'
                        $("#code").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html("");
                        // Remove quaisquer classes de validação e mensagens de erro para o campo 'discount_amount'
                        $("#discount_amount").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html("");
                    } else {
                        // Caso haja erros na resposta, captura os erros
                        var errors = response['errors'];
                        // Verifica se há erro no campo 'code'
                        if (errors['code']) {
                            // Adiciona classe de erro e exibe a mensagem de erro para o campo 'code'
                            $("#code").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors['code']);
                        } else {
                            // Remove classes de erro e mensagem de erro para o campo 'code'
                            $("#code").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html("");
                        }

                        // Verifica se há erro no campo 'discount_amount'
                        if (errors['discount_amount']) {
                            // Adiciona classe de erro e exibe a mensagem de erro para o campo 'discount_amount'
                            $("#discount_amount").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors['discount_amount']);
                        } else {
                            // Remove classes de erro e mensagem de erro para o campo 'discount_amount'
                            $("#discount_amount").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html("");
                        }
                        // Verifica se há erro no campo 'starts_at'
                        if (errors['starts_at']) {
                            // Adiciona classe de erro e exibe a mensagem de erro para o campo 'starts_at'
                            $("#starts_at").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors['starts_at']);
                        } else {
                            // Remove classes de erro e mensagem de erro para o campo 'starts_at'
                            $("#starts_at").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html("");
                        }
                        // Verifica se há erro no campo 'expires_at'
                        if (errors['expires_at']) {
                            // Adiciona classe de erro e exibe a mensagem de erro para o campo 'expires_at'
                            $("#expires_at").addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(errors['expires_at']);
                        } else {
                            // Remove classes de erro e mensagem de erro para o campo 'expires_at'
                            $("#expires_at").removeClass('is-invalid').siblings('p').removeClass(
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
    </script>
    <script>
        $(document).ready(function() {
            $('#starts_at').datetimepicker({
                // options here
                format: 'Y-m-d H:i:s',
            });
            $('#expires_at').datetimepicker({
                // options here
                format: 'Y-m-d H:i:s',
            });
        });
    </script>
@endsection
