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
    @include('admin.message')
    <div class="card">
        <div class="card-header p-2">
            <div class="card-tools">
                <a class="btn btn-secondary float-end" href="{{ route('categories.index') }}"><i class="bi bi-arrow-left-circle me-1"></i>Voltar</a>
            </div>
        </div>
        <div class="card-body mt-2 ">
            <!-- Custom Styled Validation -->
            <form action='' method="POST" id="shippingForm" name="shippingForm">
                <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                            <select name="country_id" id="country_id" class="form-control">
                                <option value="">Select a Country</option>
                                @if ($countries->isNotEmpty())
                                    @foreach ($countries as $country)
                                        <option {{($shippingCharge->country_id==$country->id)? 'selected':'' }} value="{{ $country->id }}">{{ $country->name }}
                                        </option>
                                    @endforeach
                                @endif
                               
                            </select>
                             <p></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <input type="text" name="amount" id="amount" class="form-control" placeholder="amount" value="{{$shippingCharge->amount}}">
                            <p></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary"><i class="ri-save-2-line me-1 "></i>Guardar</button></div>
                    </div>
                </div> 
            </form>
        </div>
    </div>
@endsection
@section('script_add')
    <script>
        // Função executada quando o formulário com o ID "shippingForm" é enviado
        $("#shippingForm").submit(function(event) {
            // Impede o envio padrão do formulário
            event.preventDefault();
            $("button[type=submit]").prop('disabled', true)
            // Captura o elemento do formulário
            var element = $(this);

            // Requisição AJAX para enviar os dados do formulário para a rota 'categories.store'
            $.ajax({
                url: '{{  route('shipping.update', $shippingCharge->id) }}',
                type: 'put',
                data: element.serializeArray(), // Serializa os dados do formulário
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false)
                    // Verifica se a resposta indica sucesso
                    if (response['status'] == true) {
                        window.location.href = "{{ route('shipping.create') }}"
                        // Remove quaisquer classes de validação e mensagens de erro para o campo 'amount'
                        $("#amount").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html("");
                        // Remove quaisquer classes de validação e mensagens de erro para o campo 'country_id'
                        $("#country_id").removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html("");
                    } else {
                        // Caso haja erros na resposta, captura os erros
                        var errors = response['errors'];
                        // Verifica se há erro no campo 'amount'
                        if (errors['amount']) {
                            // Adiciona classe de erro e exibe a mensagem de erro para o campo 'amount'
                            $("#amount").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors['amount']);
                        } else {
                            // Remove classes de erro e mensagem de erro para o campo 'amount'
                            $("#amount").removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html("");
                        }

                        // Verifica se há erro no campo 'country_id'
                        if (errors['status']) {
                            // Adiciona classe de erro e exibe a mensagem de erro para o campo 'country_id'
                            $("#country_id").addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(errors['country_id']);
                        } else {
                            // Remove classes de erro e mensagem de erro para o campo 'country_id'
                            $("#country_id").removeClass('is-invalid').siblings('p').removeClass(
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

@endsection
