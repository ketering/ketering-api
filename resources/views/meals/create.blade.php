@extends('adminlte::page')
@section('plugins.Summernote', true)
@section('plugins.Select2', true)

@section('content_header')
    <h3 class="m-0 text-dark">Create New Meal Type</h3>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('meals.store') }}" enctype="multipart/form-data"
                  autocomplete="off">
                @csrf

                <div class="row">
                    <div class="col-6">
                        <x-adminlte-input type="text" enable-old-support name="name" label="Name" placeholder="Name"/>
                    </div>
                    <div class="col-6">
                        <x-adminlte-input type="number" min="0" enable-old-support name="price" label="Price"
                                          placeholder="Price">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-euro-sign"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <x-adminlte-select2 enable-old-support name="category_id" label="Kategorija" label-class="">
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-folder"></i>
                                </div>
                            </x-slot>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <div class="col-6">
                        @php
                            $config = [
                                "placeholder" => "Izaberi tipove hrane",
                                "allowClear" => false,
                            ];
                        @endphp
                        <x-adminlte-select2 id="sel2Category" name="types[]" label="Tip"
                                            :config="$config" multiple>
                            <x-slot name="prependSlot">
                                <div class="input-group-text">
                                    <i class="fas fa-folder"></i>
                                </div>
                            </x-slot>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <x-adminlte-text-editor enable-old-support class="form-control" name="description"
                                                label="Description"
                                                placeholder="Description" :config="['height' => '200']"/>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@stop

@section('js')


@stop
