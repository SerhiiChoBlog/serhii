<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Serhii Cho">
    <meta name="description" content="@stack('description', "Serhii Cho is a software developer and writer with lots of experience creating web applications and programs written in different languages")">
    <meta property="og:locale" content="en_US">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" sizes="50x50">
    <title>@stack('title'){{ request()->is('/') ? 'Serhii Cho Blogs' : '' }}</title>
    @vite('resources/css/app.css')
    @stack('head')
</head>
<body class="text-font font-main bg-page {{ request()->cookie('theme') }}">
    <main id="app">
        @yield('content')
        <to-top></to-top>
    </main>
    @vite('resources/vue/app.ts')
</body>
</html>
