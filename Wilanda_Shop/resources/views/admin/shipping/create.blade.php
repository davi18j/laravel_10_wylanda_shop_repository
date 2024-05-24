@extends('admin.layouts.app')
@section('main_content')
    <div class="pagetitle">
        <h1> Entregas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Entrega</li>
            </ol>
        </nav>
    </div>
    @include('admin.message')
    <div class="card pt-2 ">
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
                                        <option value="{{ $country->id }}">{{ $country->name }}
                                        </option>
                                    @endforeach
                                @endif
                               
                            </select>
                             <p></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <input type="text" name="amount" id="amount" class="form-control" placeholder="amount">
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

    <div class="card">
        <div class="card-body">
            <!-- Table with stripped rows -->
            <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                <div class="datatable-container table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Nome</th>
                                <th>amount</th>
                                <th class="text-center" width="100">Ação</th>
                            </tr>                                        
                        </thead>
                        <tbody>
                            @if ($shippingCharges->isNotEmpty())
                                @foreach ($shippingCharges as $shipping)
                                    <tr data-index="0">
                                        <td>{{ $shipping->id }}</td>
                                        <td>{{ $shipping->name }}</td>
                                        <td>{{ $shipping->amount }} AOA</td>

                                        <td class="text-center">
                                            <a class="text-primary me-2"
                                                href="{{ route('shipping.edit', $shipping->id) }}"> <i
                                                    class="ri-edit-2-line"></i></a>
                                            <a href="#" onclick="deleteCategory({{ $shipping->id }})"
                                                class="text-danger"><i class="ri-delete-bin-6-line"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="6">Registros não encontrados</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="datatable-bottom">
                    <nav class="datatable-pagination">
                        {{ $shippingCharges->links() }}
                    </nav>
                </div>
            </div>
            <!-- End Table with stripped rows -->

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
                url: '{{ route('shipping.store') }}',
                type: 'post',
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
                        if (errors['country_id']) {
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
           <script>
            function deleteCategory(id) {
                var url = '{{ route('shipping.delete', 'ID') }}';
                var newUrl = url.replace('ID', id);
                if (confirm('Tem certeza que deseja deletar?')) {
                    $.ajax({
                        url: newUrl,
                        type: 'delete',
                        data: {},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response['status']) {
                                window.location.href = "{{ route('shipping.create') }}"
                            }
                        }
                    });
                }
            }
        </script>

@endsection
