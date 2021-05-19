<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Serhii Cho is a fullstack developer with lots of experience creating web applications and programs written in different languages.">
    <title>@yield('title') | {{ config('app.name', 'Serhii API') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('head')
</head>
<body>
    <div id="app">
        @yield('content')
    </div>

    <div id="modals"></div>

    <script src="{{ mix('js/app.js') }}" defer></script>
    <script>
        if (typeof hljs !== 'undefined') {
            const blocks = document.querySelectorAll('pre code')
            blocks.forEach(function (block) {
                hljs.highlightElement(block)
            })
        }
    </script>
</body>
</html>
