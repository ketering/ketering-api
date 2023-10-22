@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)

@section('content_header')
    <h3 class="m-0 text-dark"></h3>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-meals">
                    <h3 class="meals-username text-center"> <i class="{{ $status->icon }}"></i> {{ $status->name }}</h3>
                    <p class="text-muted text-center"></p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Obroci</b> <a class="float-right">
                                {{ $status->orders->count() }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="orders-tab" data-toggle="tab" href="#orders" role="tab"
                               aria-controls="orders" aria-selected="true">narudžbine</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab"
                               aria-controls="settings" aria-selected="false">Podesavanja</a>
                        </li>
                    </ul>

                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="orders" role="tabpanel"
                             aria-labelledby="orders-tab">
                            <table id="datatable" class="table table-striped table-bordered"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>Opcije</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($status->orders as $order)
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="#"
                                               class="btn btn-outline-primary ml-2 mr-2"><i class="fas fa-eye"></i></a>
                                        </div>
                                    </td>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Opcije</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <form method="post" action="{{ route('statuses.update', $status) }}"
                                  enctype="multipart/form-data"
                                  autocomplete="off">
                                @csrf
                                @method('PATCH')

                                <x-adminlte-input enable-old-support value="{{ $status->name }}" name="name"
                                                  label="Name"
                                                  placeholder="Name"/>
                                <button type="submit" class="btn btn-primary">Potvrdi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@stop

@section('js')
    <script>
        var table = $('#datatable').DataTable({
            responsive: true,
            autoWidth: true,
            columnDefs: [
                {targets: "_all", className: "text-center"},
                {targets: -1, searchable: false, orderable: false}
            ]
        });

        $('#meals-tab').on('shown.bs.tab', function () {
            table.responsive.recalc();
        })
    </script>
@endsection
