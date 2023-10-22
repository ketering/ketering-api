@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesResponsive', true)
@section('plugins.Summernote', true)
@section('plugins.Select2', true)

@section('content_header')
    <h3 class="m-0 text-dark">View Single Meal</h3>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-meals">
                    <h3 class="meals-username text-center">{{ $meal->name }}</h3>
                    <p class="text-muted text-center"></p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Kategorija</b> <a href="{{ route('categories.show', $meal->category) }}"
                                                 class="float-right">
                                <i class="{{ $meal->category->icon }}"></i>
                                {{ $meal->category->name }}
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Tip</b>
                            <p class="float-right m-0">
                                @foreach($meal->types as $type)
                                    {{ $type->name }},
                                @endforeach
                            </p>
                        </li>
                        <li class="list-group-item">
                            <b>Ocjena</b>
                            <p class="float-right m-0">
                                <b>{{ $meal->avg_rating }}</b>
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
                            <a class="nav-link active" id="rating-tab" data-toggle="tab" href="#rating" role="tab"
                               aria-controls="meals" aria-selected="true">Ocjene</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab"
                               aria-controls="settings" aria-selected="false">Settings</a>
                        </li>
                    </ul>

                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="rating" role="tabpanel"
                             aria-labelledby="rating-tab">
                            <table id="datatable" class="table table-striped table-bordered"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>Ime</th>
                                    <th>Kompanija</th>
                                    <th>Ocjena</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->user->name }} {{ $order->user->surname }}</td>
                                        <td>{{ $order->user->company->name }}</td>
                                        <td>{{ $order->meals()->where('meal_id', $meal->id)->withPivot('rating')->get()->first()->pivot->rating ?? 'Nema ocjene' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <form method="post" action="{{ route('meals.update', $meal) }}"
                                  enctype="multipart/form-data"
                                  autocomplete="off">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-6">
                                        <x-adminlte-input type="text" value="{{ $meal->name }}" enable-old-support
                                                          name="name" label="Name"
                                                          placeholder="Name"/>
                                    </div>
                                    <div class="col-6">
                                        <x-adminlte-input type="number" step="0.01" value="{{ $meal->price }}" min="0"
                                                          enable-old-support name="price"
                                                          label="Price"
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
                                        <x-adminlte-select2 enable-old-support name="category_id" label="Kategorija"
                                                            label-class="">
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text">
                                                    <i class="fas fa-folder"></i>
                                                </div>
                                            </x-slot>
                                            @foreach($categories as $category)
                                                <option
                                                    {{ $category->id === $meal->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
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
                                                <option
                                                    {{ $meal->types->contains($type) ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <x-adminlte-text-editor enable-old-support class="form-control"
                                                                name="description"
                                                                label="Description"
                                                                placeholder="Description"
                                                                :config="['height' => '200']">
                                            {!! $meal->description !!}
                                        </x-adminlte-text-editor>
                                    </div>
                                </div>

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
