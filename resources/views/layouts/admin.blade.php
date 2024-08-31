<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-head />

    @vite('resources/css/main/app.css')
    @vite('resources/css/admin/app.css')
    @vite('resources/css/admin/font-awesome.css')

    @stack('head')
</head>
<body class="text-font font-main bg-page {{ request()->cookie('theme') }}">
    <x-hero class="bg-gray-700" navbar="text-white" id="main" />

    @auth('admin')
        <main id="admin-main"></main>
    @endauth

    <script type="text/javascript">
        window.Auth = {!! json_encode(user()) !!}
    </script>

    @vite('resources/ts/main/app.ts')
    @vite('resources/ts/admin/app.ts')
</body>
</html>
