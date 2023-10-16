@extends('adminlte::page')

@section('content_header')
    <h3 class="m-0 text-dark">Pregled korisnika</h3>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header p-2">
                    <ul class="nav nav-pills" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab"
                               aria-controls="info" aria-selected="true">Informacije</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab"
                               aria-controls="settings" aria-selected="false">Podešavanja</a>
                        </li>
                    </ul>

                </div>
                <div class="card-body box-profile">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="info" role="tabpanel"
                             aria-labelledby="info-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <div
                                        class="d-flex align-items-center justify-content-center text-center h-100 mb-5">
                                        <div>
                                            <div class="text-center">
                                                <img class="profile-user-img img-fluid img-circle"
                                                     src="{{ $user->adminlte_image() }}"
                                                     alt="User profile picture">
                                            </div>

                                            <h2 class="h2 mt-2 font-weight-semibold">{{ $user->name }} {{ $user->surname }}</h2>

                                            <p class="text-muted">
                                                @if($user->role == App\Models\Role::superadmin())
                                                    <span class="badge badge-danger">Super Admin</span>
                                                @elseif($user->role == App\Models\Role::admin())
                                                    <span class="badge badge-danger">Admin</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $user->role->name }}</span>
                                                @endif
                                            </p>
                                            <p class="text-muted">{{ $user->email }} </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                                            <p class="text-muted">
                                                <a href="mailto:{{ $user->email }}"
                                                   class="link-primary"> {{$user->email}}
                                                </a>
                                            </p>

                                            <hr>


                                            <strong><i class="fas fa-building mr-1"></i> Kompanija</strong>

                                            <p class="text-muted">
                                                {{ $user->company->name ?? 'No company' }}
                                            </p>

                                            <hr>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <form action="{{ route('users.update', $user) }}" method="post">
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <x-adminlte-input enable-old-support label="Ime" placeholder="Ime"
                                                          value="{{ $user->name }}"
                                                          type="text" name="name" class="form-control" id="name"/>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <x-adminlte-input enable-old-support label="Prezime" placeholder="Prezime"
                                                          value="{{ $user->surname }}"
                                                          type="text" name="surname" class="form-control" id="surname"/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <x-adminlte-input enable-old-support label="E-Mail" placeholder="E-Mail"
                                                          value="{{ $user->email }}"
                                                          type="email" name="email" class="form-control" id="email"/>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <x-adminlte-select2 name="company_id" label="Kompanija" label-class=""
                                                            class="needsDisable">
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text">
                                                    <i class="fas fa-building"></i>
                                                </div>
                                            </x-slot>
                                            @foreach($companies as $company)
                                                <option
                                                    {{ $user->company == $company ? 'selected' : '' }} value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <x-adminlte-select2 name="role_id" label="Tip Korisnika" label-class=""
                                                            class="">
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text">
                                                    <i class="fas fa-id-badge"></i>
                                                </div>
                                            </x-slot>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </x-adminlte-select2>

                                    </div>
                                </div>

                                <hr>

                                <button type="submit" class="btn btn-primary">Ažuriraj</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{--@section('js')--}}
{{--    <script>--}}
{{--        @if(auth()->user()->role != \App\Models\Role::superadmin())--}}
{{--        $('.needsDisable').each(function (key, input) {--}}
{{--            input.disabled = true--}}
{{--        })--}}
{{--        @endif--}}
{{--    </script>--}}
{{--@stop--}}
