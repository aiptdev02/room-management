<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title') | Rooms Management</title>
    <!-- Bootstrap -->
    <link href="{{ asset('assets/theme/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/vendor/swiper/css/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/vendor/datatables/css/buttons.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/vendor/metismenu/css/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/vendor/toastr/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/theme/icons/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/theme/css/style.css') }}" rel="stylesheet">
    <!-- Style css -->
    {{-- <link class="main-css" href="{{ asset('assets/css/master.css') }}" rel="stylesheet"> --}}


    @yield('page_styles')
</head>

<body>
    @if (\Route::current()->uri() == '/' || \Route::current()->uri() == 'login')
        @yield('login')
    @else
        <div id="preloader">
            <div>
                <img src="{{ asset('assets/images/loader.gif') }}" alt="">
            </div>
        </div>
        <div id="main-wrapper">
            <div class="row gap-2 justify-content-between">
                <div class="left-pane">
                    @include('masteradmin.includes.headers')
                </div>
                <div class="right-panel">
                    @include('masteradmin.includes.top_panel')
                    <div class="content-body pt-5 pb-4">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xl-12">

                                    <div class="bg-white rounded p-4">
                                        @yield('pages')
                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- @include('master.includes.footer') --}}
                </div>
            </div>
        </div>
    @endif
    <div id="toasts"></div>
</body>

<!-- Required vendors -->
<script src="{{ asset('assets/theme/vendor/global/global.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}
<script src="{{ asset('assets/theme/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>

<!-- Dashboard 1 -->
<script src="{{ asset('assets/theme/vendor/draggable/draggable.js') }}"></script>
<script src="{{ asset('assets/theme/vendor/swiper/js/swiper-bundle.min.js') }}"></script>

<script src="{{ asset('assets/theme/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/theme/vendor/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/theme/vendor/datatables/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/theme/vendor/datatables/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/theme/js/plugins-init/datatables.init.js') }}"></script>


<!-- Vectormap -->
<script src="{{ asset('assets/theme/vendor/jqvmap/js/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/theme/vendor/jqvmap/js/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('assets/theme/vendor/jqvmap/js/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('assets/theme/js/custom.min.js') }}"></script>
<script src="{{ asset('assets/theme/js/deznav-init.js') }}"></script>
{{-- <script src="{{ asset('assets/theme/js/demo.js') }}"></script> --}}

{{-- select 2 --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Toastr -->
<script src="{{ asset('assets/theme/vendor/toastr/js/toastr.min.js') }}"></script>
<!-- All init script -->
<script src="{{ asset('assets/theme/js/plugins-init/toastr-init.js') }}"></script>
<script src="{{ asset('assets/js/front.js') }}"></script>
@yield('page_script')
<script>
    $('.show_img').click(function(e) {
        e.preventDefault();
        $('.view_img').attr('data', '');
        $('#photoviewModal').modal("show")
        var img = $(this).attr('href')
        $('.view_img').attr('data', img);
    });
</script>

</html>
