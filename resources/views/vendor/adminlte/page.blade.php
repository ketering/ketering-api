@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Preloader Animation --}}
        @if($layoutHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
    <script>
        function flashMsg(msg, type) {
            Swal.fire({
                "title": msg,
                // "text":msg,
                "timer": 5000,
                "width": "40rem",
                "padding": "1.2rem",
                "showConfirmButton": false,
                "showCloseButton": true,
                "timerProgressBar": true,
                "customClass": {
                    "container": 'z-x',
                    "popup": 'bg-dark',
                    "header": null,
                    "title": null,
                    "closeButton": null,
                    "icon": null,
                    "image": null,
                    "content": null,
                    "input": null,
                    "actions": null,
                    "confirmButton": null,
                    "cancelButton": null,
                    "footer": null
                },
                "toast": true,
                "icon": type,
                "position": "top-end"
            });
        }

        window.onload = function () {
            @if(session('success'))
            const tempMsg = "{{ session('success') }}";
            var temp = document.createElement('div');
            temp.setAttribute('hidden', 'true');
            temp.innerHTML = tempMsg;
            const msg = temp.innerHTML;

            flashMsg(msg, 'success');
            @elseif(session('fail'))
            const tempMsg1 = "{{ session('fail') }}";
            var temp1 = document.createElement('div');
            temp1.setAttribute('hidden', 'true');
            temp1.innerHTML = tempMsg1;
            const msg1 = temp1.innerHTML;

            flashMsg(msg1, 'error');
            @endif
        }
        // confirm delete sweet alert 2
        function confirmDel(evt, route, id) {
            swal.fire({
                title: "Are you sure?",
                text: "You will not be able to restore this action!",
                icon: "warning",
                showConfirmButton: true,
                showCancelButton: true,
            }).then((obj) => {
                if (obj.isConfirmed) {
                    let form = document.getElementById('submitDelete');
                    form.action = `${route}/${id}`
                    form.submit();
                }
            })
        }
    </script>
@stop
