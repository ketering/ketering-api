@extends('adminlte::page')

@section('content_header')
    <h3 class="m-0 text-dark">Novi status</h3></h3>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('statuses.store') }}" enctype="multipart/form-data"
                  autocomplete="off">
                @csrf

                <x-adminlte-input type="text" enable-old-support name="name" label="Naziv" placeholder="Naziv"/>

                <button type="submit" class="btn btn-primary">Napravi</button>
            </form>
        </div>
    </div>
@stop

@section('js')


@stop
