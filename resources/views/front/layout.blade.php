<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title') | 4050 Fitness</title>
    <!-- Bootstrap -->
    <link href="{{ asset('assets/theme/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/vendor/swiper/css/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/vendor/datatables/css/buttons.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/vendor/metismenu/css/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/vendor/toastr/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/css/style.css') }}" rel="stylesheet">

    @yield('page_styles')
</head>

<body>
    <div class="site-pages">
        @yield('pages')
    </div>
    @include('front.includes.footer')
    <div id="toasts"></div>
</body>
<script src="{{ asset('assets/theme/vendor/global/global.min.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('assets/theme/vendor/toastr/js/toastr.min.js') }}"></script>
<!-- All init script -->
<script src="{{ asset('assets/theme/js/plugins-init/toastr-init.js') }}"></script>
<script src="{{ asset('assets/js/front.js') }}"></script>

@yield('page_script')

</html>
