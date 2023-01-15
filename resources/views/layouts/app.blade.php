<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Serhii Cho">
    <meta name="description" content="@stack('description', "Serhii's Blog is a great place to learn about web development. If you are eager to learn how to build optimized, responsive and modern web, this place is for you.")">
    <meta property="og:locale" content="en_US">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" sizes="50x50">
    <link rel="canonical" href="{{ str_replace('www.', '', request()->url()) }}" />
    <title>@stack('title'){{ request()->is('/') ? "Serhii Blog" : '' }}</title>
    @vite('resources/css/main/app.css')
    @stack('head')
</head>
<body class="text-font font-main bg-page {{ request()->cookie('theme') }}">
    <main id="app">
        @yield('content')
        <to-top></to-top>
        <x-footer></x-footer>
    </main>

    @vite('resources/ts/main/app.ts')
</body>
</html>
