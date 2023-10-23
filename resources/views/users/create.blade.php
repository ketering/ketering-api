@extends('adminlte::page')
@section('plugins.Select2', true)

@section('content_header')
    <h3 class="m-0 text-dark">Novi korisnik</h3>
@stop

@section('content')
    <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data" autocomplete="off">
        @csrf

        <x-adminlte-input enable-old-support name="name" label="Ime" placeholder="Ime"/>
        <x-adminlte-input enable-old-support name="surname" label="Prezime" placeholder="Prezime"/>
        <x-adminlte-input enable-old-support name="email" type="email" label="E-mail" placeholder="E-mail"/>
        <x-adminlte-input enable-old-support name="password" type="password" label="Lozinka" placeholder="Lozinka"/>
        <x-adminlte-input enable-old-support name="password_confirmation" type="password" label="Potvrda lozinke"
                          placeholder="Potvrda lozinke"/>

        <x-adminlte-select2 name="company_id" label="Kompanija" label-class=""
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

        <x-adminlte-select name="role_id" label="Uloga korisnika" label-class="">
            <x-slot name="prependSlot">
                <div class="input-group-text">
                    <i class="fas fa-id-badge"></i>
                </div>
            </x-slot>
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </x-adminlte-select>

        <button type="submit" class="btn btn-primary">Potvrdi</button>
    </form>
@stop
