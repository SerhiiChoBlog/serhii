<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-head />
    @vite('resources/css/main/app.css')
    @stack('head')
</head>
<body class="text-font font-main bg-page {{ request()->cookie('theme') }}">
    <main id="main">
        @yield('content')
        <to-top></to-top>
        <x-footer></x-footer>
    </main>

    <script type="text/javascript">
        window.Auth = {!! json_encode(user()) !!}
    </script>

    @vite('resources/ts/main/app.ts')
    <script data-name="BMC-Widget" data-cfasync="false" src="https://cdnjs.buymeacoffee.com/1.0.0/widget.prod.min.js" data-id="serhiicho" data-description="Support me on Buy me a coffee!" data-message="" data-color="#FF813F" data-position="Right" data-x_margin="18" data-y_margin="18"></script>
</body>
</html>
