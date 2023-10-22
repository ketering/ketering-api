@extends('adminlte::page')
@section('plugins.Select2', true)
@section('plugins.DateRangePicker', true)

@section('content_header')
    <h3 class="m-0 text-dark">Generiši fakturu</h3>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('invoices.generate') }}" enctype="multipart/form-data"
                  autocomplete="off">
                @csrf

                <x-adminlte-select2 enable-old-support name="company_id" label="Kompanija" label-class=""
                                    class="needsDisable">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-building"></i>
                        </div>
                    </x-slot>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </x-adminlte-select2>

                <x-adminlte-date-range enable-old-support label="Izaberi vremenski period" name="dateRange" enable-default-ranges="Last 30 Days">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </x-slot>
                </x-adminlte-date-range>

                <button type="submit" class="btn btn-primary">Generiši</button>
            </form>
        </div>
    </div>
@stop

@section('js')


@stop
