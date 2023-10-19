@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)

@section('content_header')
    <h3 class="m-0 text-dark">View All Meals</h3>
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
                    <th>Kategorija</th>
                    <th>Ime</th>
                    <th>Cijena</th>
                    <th>Rejting</th>
                    <th>Opcije</th>
                </tr>
                </thead>
                <tbody>
                @foreach($meals as $meal)
                    <tr>
                        <td><i class="{{ $meal->category->icon }}"></i> {{ $meal->category->name }}</td>
                        <td>{{ $meal->name }}</td>
                        <td>{{ $meal->price }} <b>&#8364;</b></td>
                        <td>{{ $meal->avg_rating }}</td>
                        <td>
                            <div class="d-flex justify-content-center">

                                <a href="{{ route('meals.show', $meal) }}"
                                   class="btn btn-outline-primary ml-2 mr-2"><i class="fas fa-eye"></i></a>

                                <button onclick="confirmDel(event, '/meals', {{ $meal->id }})"
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
