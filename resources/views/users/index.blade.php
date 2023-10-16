@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)

@section('content_header')
    <h3 class="m-0 text-dark">View All Users</h3>
@stop

@section('content')

    <div id="accordion">
        <form id="submitDelete" action="" method="post" hidden="">
            @csrf
            @method('DELETE')
        </form>
        @foreach($roles as $role)
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapse{{ $role->id }}"
                           aria-expanded="false">
                            {{ $role->name }}
                        </a>
                    </h4>
                </div>
                <div id="collapse{{ $role->id }}" class="collapse" data-parent="#accordion" style="">
                    <div class="card-body">
                        <table id="datatable{{ $role->id }}" class="table table-striped table-bordered"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Surname</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($role->users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->surname }}</td>
                                    <td>{{ $user->company->name ?? 'No company' }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('users.show', $user->id) }}"
                                               class="btn btn-outline-primary ml-2 mr-2"><i class="fas fa-eye"></i></a>
                                            <button onclick="confirmDel(event, '/users', {{ $user->id }})"
                                                    class="btn btn-outline-danger ml-2 delete-user"><i
                                                    class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Surname</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Options</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@stop

@section('js')
    <script>
        @foreach($roles as $role)
        var table{{ $role->id }} = $('#datatable{{ $role->id }}').DataTable({
            responsive: true,
            autoWidth: true,
            columnDefs: [
                {targets: -1, searchable: false, orderable: false}
            ]
        });
        @endforeach
        $('.collapse').on('shown.bs.collapse', function (evt) {
            var num = String(evt.target.id).replace('collapse', '');
            var table = window[`table${num}`];
            table.responsive.recalc();
        })
    </script>
@stop
