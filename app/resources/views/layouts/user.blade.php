<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-head />

    @vite('resources/css/main/app.css')

    @stack('head')
</head>
<body class="text-font font-main bg-page {{ request()->cookie('theme') }}">
    <x-hero class="bg-gray-700" navbar="text-white" id="main" />

    <main id="user-main" class="mt-10">
        @yield('content')
        <sign-in-modal></sign-in-modal>
    </main>

    <script type="text/javascript">
        window.Auth = {!! json_encode(user()) !!}
    </script>

    @vite('resources/ts/user/app.ts')
    @vite('resources/ts/main/app.ts')
</body>
</html>
