@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)

@section('content_header')
    <h3 class="m-0 text-dark">View Single Status</h3>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-meals">
                    <h3 class="meals-username text-center"> {{ $status->name }}</h3>
                    <p class="text-muted text-center"></p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Order</b> <a class="float-right">
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
                            <a class="nav-link active" id="meals-tab" data-toggle="tab" href="#meals" role="tab"
                               aria-controls="meals" aria-selected="true">Status</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab"
                               aria-controls="settings" aria-selected="false">Settings</a>
                        </li>
                    </ul>

                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="meals" role="tabpanel"
                             aria-labelledby="meals-tab">
                            <table id="datatable" class="table table-striped table-bordered"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($status->orders as $statuses)
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
                                    <th>Options</th>
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
                                <button type="submit" class="btn btn-primary">Submit</button>
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
