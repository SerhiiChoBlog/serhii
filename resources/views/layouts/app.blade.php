<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Serhii API') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('head')
</head>
<body>
    <div id="app">
        <nav class="navbar is-dark mb-6">
            <div class="container">
                <div class="navbar-brand">
                    <a href="{{ url('/') }}" class="navbar-item">
                        <b>SERHII<span class="has-text-info">CHO</span></b>
                    </a>

                    <a role="button" class="navbar-burger">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>

                <div class="navbar-menu">
                    <div class="navbar-end">
                        @auth
                            <a href="{{ route('home') }}" class="navbar-item {{ request()->is('/') ? 'is-active' : '' }}">About</a>
                            <a href="{{ route('posts.index') }}" class="navbar-item {{ request()->is('posts') ? 'is-active' : '' }}">Posts</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="pb-6">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="is-hidden">
    @csrf
</form>
