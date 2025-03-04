<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/frontend/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/datepicker.material.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/vendor/toastr/toastr.min.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('front_styles')
</head>
<body class="dashboard">

<div id="main-wrapper">
    @include('frontend.layouts.header')
    <div class="content-body">
        @yield('content')
    </div>
</div>

<script defer src="{{ asset('assets/frontend/vendor/jquery/jquery.min.js') }}"></script>
<script defer src="{{ asset('assets/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{--<script defer src="{{ asset('assets/frontend/vendor/chartjs/chartjs.js') }}"></script>--}}
<script defer src="{{ asset('assets/frontend/js/plugins/chartjs-bar-income-vs-expense.js') }}"></script>
<script defer src="{{ asset('assets/frontend/js/scripts.js') }}"></script>

@yield('front_scripts')
</body>
</html>
