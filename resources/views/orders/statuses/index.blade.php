@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)

@section('content_header')
    <h3 class="m-0 text-dark">View All Order Statuses</h3>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="submitDelete" action="" method="post" hidden="">
                @csrf
                @method('DELETE')
            </form>
            <table id="datatable" class="table table-striped table-bordered"
                   style="width:100%">
                <thead>
                <tr>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Options</th>
                </tr>
                </thead>
                <tbody>
                @foreach($statuses as $status)
                    <tr>
                        <td><i class="{{ $status->icon }}"></i></td>
                        <td>{{ $status->name }}</td>
                        <td>
                            <div class="d-flex justify-content-center">

                                <a href="{{ route('statuses.show', $status) }}"
                                   class="btn btn-outline-primary ml-2 mr-2"><i class="fas fa-eye"></i></a>

                                <button onclick="confirmDel(event, '/statuses', {{ $status->id }})"
                                        class="btn btn-outline-danger ml-2 delete-user"><i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
    </script>
@stop
