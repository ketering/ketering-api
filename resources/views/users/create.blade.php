@extends('adminlte::page')

@section('content_header')
    <h3 class="m-0 text-dark">Create new User</h3>
@stop

@section('content')
    <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data" autocomplete="off">
        @csrf

        <x-adminlte-input enable-old-support name="name" label="Name" placeholder="Name"/>
        <x-adminlte-input enable-old-support name="surname" label="Surname" placeholder="Surname"/>
        <x-adminlte-input enable-old-support name="email" type="email" label="E-mail" placeholder="E-mail"/>
        <x-adminlte-input enable-old-support name="password" type="password" label="Password" placeholder="Password"/>
        <x-adminlte-input enable-old-support name="password_confirmation" type="password" label="Password Confirmation"
                          placeholder="Password Confirmation"/>


        <x-adminlte-select name="role_id" label="User Role" label-class=""
                           igroup-size="lg">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-id-badge"></i>
                </div>
            </x-slot>
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </x-adminlte-select>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@stop
