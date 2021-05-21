<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Serhii API') }}</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    @yield('head')
</head>
<body>
    <div>
        <nav class="navbar is-dark mb-6">
            <div class="container">
                <div class="navbar-brand">
                    <a href="{{ route('home') }}" class="navbar-item">
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
                        <a href="{{ route('admin.dashboard') }}" class="navbar-item {{ request()->is('admin/dashboard') ? 'is-active' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.posts.index') }}" class="navbar-item {{ request()->is('admin/posts') ? 'is-active' : '' }}">Posts</a>
                        <a href="{{ route('admin.tags.index') }}" class="navbar-item {{ request()->is('admin/tags') ? 'is-active' : '' }}">Tags</a>
                        <a href="{{ route('admin.page_views.index') }}" class="navbar-item {{ request()->is('admin/page-views') ? 'is-active' : '' }}">Page views</a>
                        <a href="{{ route('admin.visitors.index') }}" class="navbar-item {{ request()->is('admin/visitors') ? 'is-active' : '' }}">Visitors</a>
                        <a href="{{ route('admin.social-shares.index') }}" class="navbar-item {{ request()->is('admin/social-shares') ? 'is-active' : '' }}">Shares</a>
                        <a href="{{ route('logout') }}"
                           class="navbar-item"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit()"
                        >
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="pb-6">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/admin.js') }}" defer></script>
</body>
</html>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="is-hidden">
    @csrf
</form>
