@php
    /** @var ?boolean $is_light */
@endphp

<nav class="navbar" style="{{ ($is_grey ?? false) ? 'background-color: #f5f5f5' : '' }}">
    <div class="container">
        <div class="navbar-brand">
            <a href="{{ url('/') }}" class="navbar-item">
                <b>SERHII<span class="has-text-info">CHO</span></b>
            </a>

           <hamburger {{ ($is_light ?? false) ? ':is-light="true"' : '' }} />
        </div>

        <div class="navbar-menu" id="navbar-menu">
            <div class="navbar-end">
                <a href="{{ route('home') }}" class="navbar-item has-stripe {{ request()->is('/') ? 'is-active' : '' }}">About</a>
                <a href="{{ route('projects.index') }}" class="navbar-item has-stripe {{ request()->is('projects') ? 'is-active' : '' }}">Open Source</a>
{{--                <a href="{{ route('posts.index') }}" class="navbar-item has-stripe {{ request()->is('posts') ? 'is-active' : '' }}">Blog</a>--}}
                <div class="navbar-item"><contact-modal /></div>
            </div>
        </div>
    </div>
</nav>
