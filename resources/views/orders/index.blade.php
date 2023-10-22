@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)
@section('plugins.TempusDominusBs4', true)

@section('content_header')
    <h3 class="m-0 text-dark">Pregled svih narudžbina <b>@php echo $_GET['forDate'] ?? 'Today' @endphp </b></h3>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="">
                <div class="row">
                    <div class="col-5">
                        @php
                            $config = ['format' => 'L'];
                        @endphp
                        <x-adminlte-input-date name="forDate" :config="$config" placeholder="Izaberi datum">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                    </div>
                    <div class="col-5">
                        <x-adminlte-select onchange="this.form.submit()" enable-old-support name="status"
                                           placeholder="Izaberi status"
                                           label-class="">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-folder"></i>
                                </div>
                            </x-slot>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </x-adminlte-select>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-outline-primary float-right">Filter</button>
                    </div>
                </div>
            </form>
            <table id="datatable" class="table table-striped table-bordered"
                   style="width:100%">
                <thead>
                <tr>
                    <th>Kompanija</th>
                    <th>Cijena</th>
                    <th>Rejting</th>
                    <th>Status</th>
                    <th>Datum</th>
                    <th>Opcije</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->user->company->name }}</td>
                        <td>{{ $order->totalPrice }} <b>&#8364;</b></td>
                        <td>{{ $order->rating }}</td>
                        <td>
                            <form action="{{ route('order.change-status', $order) }}" method="post">
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
                                        <option {{ $status->id == $order->status_id ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </x-adminlte-select>
                            </form>
                        </td>
                        <td>{{ date('d.m.Y', strtotime($order->forDate)) }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('orders.show', $order) }}"
                                   class="btn btn-outline-primary ml-2 mr-2"><i class="fas fa-eye"></i></a>
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

        let params = (new URL(document.location)).searchParams;
        let date = params.get('forDate');
        let status = params.get('status');
        window.addEventListener("load", (event) => {
            $('#forDate').val(date ?? moment().format('MM/DD/YYYY'))
            $('#status').val(status ?? 1)
        });
    </script>
@stop
