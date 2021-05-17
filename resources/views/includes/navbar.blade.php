@php
    /** @var ?boolean $is_light */
@endphp

<nav class="navbar mb-6" style="{{ ($is_grey ?? false) ? 'background-color: #f5f5f5' : '' }}">
    <div class="container">
        <div class="navbar-brand">
            <a href="{{ url('/') }}" class="navbar-item">
                <b>SERHII<span class="has-text-info">CHO</span></b>
            </a>

            <a role="button" class="navbar-burger {{ ($is_light ?? false) ? '' : 'burger-light' }}">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div class="navbar-menu">
            <div class="navbar-end">
                <a href="{{ route('home') }}" class="navbar-item has-stripe {{ request()->is('/') ? 'is-active' : '' }}">About</a>
                <a href="{{ route('projects.index') }}" class="navbar-item has-stripe {{ request()->is('projects') ? 'is-active' : '' }}">Open Source</a>
{{--                <a href="{{ route('posts.index') }}" class="navbar-item has-stripe {{ request()->is('posts') ? 'is-active' : '' }}">Blog</a>--}}
                <div class="navbar-item"><contact-modal /></div>
            </div>
        </div>
    </div>
</nav>
