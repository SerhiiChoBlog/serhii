<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Serhii Cho">
    <meta name="description" content="@yield('description', "Serhii Cho is a software developer and blogger with lots of experience creating web applications and programs written in Laravel, Vue and React")">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <title>@yield('title'){{ request()->is('/') ? '' : ' | ' }}{{ config('app.name', 'Serhii API') }}</title>
    <link href="{{ App\FileVersion::append('/css/app.css') }}" rel="stylesheet">
    @yield('head')
</head>
<body class="text-font font-main bg-page {{ request()->cookie('theme') }}">
    <main id="app">
        @yield('content')
        <to-top></to-top>
    </main>

    <script src="{{ App\FileVersion::append('/js/app.js') }}"></script>
</body>
</html>
