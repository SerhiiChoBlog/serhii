<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Serhii API') }}</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    @yield('head')
</head>
<body>
    @include('includes.user-sidebar')
    <main class="py-6">
        @yield('content')
    </main>
    <script src="{{ asset('js/admin.js') }}" defer></script>
</body>
</html>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="is-hidden">
    @csrf
</form>
