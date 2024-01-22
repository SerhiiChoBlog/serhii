<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @if (app()->environment('production'))
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-PDEVGVHPVM"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-PDEVGVHPVM');
        </script>
    @endif
    <x-head />
    @vite('resources/css/main/app.css')
    @stack('head')
</head>
<body class="text-font font-main bg-page {{ request()->cookie('theme') }}">
    <main id="main">
        @yield('content')
        <x-footer></x-footer>
        <sign-in-modal></sign-in-modal>
    </main>

    <script type="text/javascript">
        window.Auth = {!! json_encode(user()) !!}
    </script>

    @vite('resources/ts/main/app.ts')
</body>
</html>
