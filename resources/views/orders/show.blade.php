@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)
@section('plugins.Summernote', true)
@section('plugins.Select2', true)

@section('content_header')
    <span class="mt-3"></span>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-meals">
                    <h3 class="meals-username text-center">Narudžbina <b>{{ $order->id }}</b></h3>
                    <p class="text-muted text-center"></p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <b>Status</b>
                            <form class="" action="{{ route('order.change-status', $order) }}" method="post">
                                @csrf
                                <x-adminlte-select onchange="this.form.submit()" enable-old-support name="status"
                                                   placeholder="Izaberi status"
                                                   label-class="">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text">
                                            <i class="{{ $order->status->icon }}"></i>
                                        </div>
                                    </x-slot>
                                    @foreach($statuses as $status)
                                        <option
                                            {{ $status->id == $order->status_id ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </x-adminlte-select>
                            </form>
                        </li>
                        <li class="list-group-item">
                            <b>Kompanija</b>
                            <p class="float-right m-0">
                                {{ $order->user->company->name }}
                            </p>
                        </li>
                        <li class="list-group-item">
                            <b>Korisnik</b>
                            <p class="float-right m-0">
                                {{ $order->user->name }} {{ $order->user->surname }}
                            </p>
                        </li>
                        <li class="list-group-item">
                            <b>Cijena</b>
                            <p class="float-right m-0">
                                {{ $order->totalPrice }} <b>&#8364;</b>
                            </p>
                        </li>
                        <li class="list-group-item">
                            <b>Za datum</b>
                            <p class="float-right m-0">
                                {{ \Carbon\Carbon::parse($order->forDate)->format('d-m-Y') }}
                            </p>
                        </li>
                        <li class="list-group-item">
                            <b>Ocjena korisnika</b>
                            <p class="float-right m-0">
                                <b>{{ $order->rating }}</b>
                            </p>
                        </li>
                        <li class="list-group-item">
                            <b>Napomena</b>
                            <p class="float-right m-0">
                                {{ $order->description }}
                            </p>
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
                               aria-controls="meals" aria-selected="true">Meals</a>
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
                                    <th>Naziv</th>
                                    <th>Količina</th>
                                    <th>Cijena</th>
                                    <th>Ocjena Korisnika</th>
                                    <th>Opcije</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->meals()->withPivot('rating', 'amount')->get() as $meal)
                                    <tr>
                                        <td>{{ $meal->name }}</td>
                                        <td>{{ $meal->pivot->amount }}</td>
                                        <td>{{ $meal->price }} <b>&#8364;</b></td>
                                        <td><b>{{ $meal->pivot->rating }}</b></td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('meals.show', $meal) }}"
                                                   class="btn btn-outline-primary ml-2 mr-2"><i class="fas fa-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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
        });
    </script>
@endsection
