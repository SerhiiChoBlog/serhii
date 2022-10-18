<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Serhii API') }}</title>
    @vite('resources/css/admin/admin.css')
    @vite('resources/css/admin/font-awesome.css')
    @stack('head')
</head>
<body>
    <main id="admin-main"></main>
    @vite('resources/admin/app.ts')
</body>
</html>
