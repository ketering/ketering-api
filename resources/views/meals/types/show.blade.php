@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)

@section('content_header')
    <h3 class="m-0 text-dark">View Single Meal Type</h3>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-meals">
                    <h3 class="meals-username text-center"> <i class="{{ $type->icon }}"></i> {{ $type->name }}</h3>
                    <p class="text-muted text-center"></p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Meals</b> <a class="float-right">
                                {{ $type->meals->count() }}
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
                            <a class="nav-link active" id="meal-tab" data-toggle="tab" href="#meal" role="tab"
                               aria-controls="meal" aria-selected="true">Meals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab"
                               aria-controls="settings" aria-selected="false">Settings</a>
                        </li>
                    </ul>

                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="meal" role="tabpanel"
                             aria-labelledby="meal-tab">
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
                                @foreach($type->meals as $meal)
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

                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <form method="post" action="{{ route('types.update', $type) }}"
                                  enctype="multipart/form-data"
                                  autocomplete="off">
                                @csrf
                                @method('PATCH')

                                <x-adminlte-input enable-old-support value="{{ $type->name }}" name="name"
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
