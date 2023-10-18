@extends('adminlte::page')

@section('content_header')
    <h3 class="m-0 text-dark">Create New Meal Category</h3>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('categories.store') }}" enctype="multipart/form-data"
                  autocomplete="off">
                @csrf

                <x-adminlte-input type="text" enable-old-support name="name" label="Name" placeholder="Name"/>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@stop

@section('js')


@stop
