@extends('admin.layouts.app')
@section('main_content')
    <div class="pagetitle">
        <h1>Categória</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item">Categórias</li>
                <li class="breadcrumb-item active">Categória</li>
            </ol>
        </nav>
    </div>
    @include('admin.message')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="ms-3 mt-2  ">
                        <a class="btn btn-light" href="{{ route('discount.index') }}"><i
                                class="bi bi-arrow-counterclockwise"></i></a>
                    </div>
                    <div class="card-header">
                        <div class="card-tools">
                            <a class="btn btn-primary float-end mt-2 " href="{{ route('discount.create') }}"><i
                                class="bx bx-plus-circle me-1"></i>
                                Categória</a>
                            <form action="" method="GET">
                                <div class="input-group input-group" style="width: 250px;">
                                    <input type="text" value="{{ Request::get('keyword') }}" name="keyword"
                                        class="form-control float-right" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Table with stripped rows -->
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-container table-responsive">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th width="60">ID</th>
                                            <th>Código</th>
                                            <th>Nome</th>
                                            <th>Disconto</th>
                                            <th>Inicio</th>
                                            <th>Expiração</th>
                                            <th class="text-center" width="100">Status</th>
                                            <th class="text-center" width="100">Ação</th>
                                        </tr>                                        
                                    </thead>
                                    <tbody>
                                        @if ($discountCoupon->isNotEmpty())
                                            @foreach ($discountCoupon as $discount)
                                                <tr data-index="0">
                                                    <td>{{ $discount->id }}</td>
                                                    <td>{{ $discount->name }}</td> 
                                                    <td>{{ $discount->code }}</td> 
                                                    <td>
                                                    @if ($discount->type == 'percent' )
                                                            {{ $discount->discount_amount }} %
                                                    @else
                                                    {{ $discount->discount_amount }}
                                                    @endif
                                                   </td>
                                                   <td> {{(!empty($discount->starts_at))? \Carbon\Carbon::parse($discount->starts_at)->format('Y/m/d H:i:s'): ''}}</td>
                                                   <td> {{(!empty($discount->expires_at))? \Carbon\Carbon::parse($discount->expires_at)->format('Y/m/d H:i:s'): ''}}</td>
            
                                                   <td class="text-center">
                                                        @if ($discount->status == 1)
                                                            <span class="text-success"><i
                                                                    class="bi bi-check-circle"></i></span>
                                                        @else
                                                            <span class="text-danger"><i class="bx bx-block"></i></span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a class="text-primary me-2"
                                                            href="{{ route('categories.edit', $discount->id) }}"> <i
                                                                class="ri-edit-2-line"></i></a>
                                                        <a href="#" onclick="deletediscount({{$discount->id}})" class="text-danger"  ><i
                                                                class="ri-delete-bin-6-line"></i></a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">Registros não encontrados</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="datatable-bottom">
                                <nav class="datatable-pagination">
                                    {{ $discountCoupon->links() }}
                                </nav>
                            </div>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('script_add')
    <script>
        function deletediscount(id) {
          var  url='{{route('categories.delete','ID')}}';
          var newUrl = url.replace('ID', id);
          if (confirm('Tem certeza que deseja deletar a Categória?')) {
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
                        window.location.href = "{{ route('discount.index') }}"
                    } 
                }
            });
          }
        }
    </script>
@endsection
