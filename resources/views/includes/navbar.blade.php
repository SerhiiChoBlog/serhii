@php
    /** @var ?boolean $is_light */
@endphp

<nav class="navbar" style="{{ ($is_grey ?? false) ? 'background-color: #f5f5f5' : '' }}">
    <div class="container">
        <div class="navbar-brand">
            <a href="{{ route('home') }}" class="navbar-item">
                <b>SERHII<span class="has-text-info">CHO</span></b>
            </a>

           <hamburger {{ ($is_light ?? false) ? ':is-light="true"' : '' }} />
        </div>

        <div class="navbar-menu" id="navbar-menu">
            <div class="navbar-end">
                @auth
                    <a href="{{ route('admin.posts.index') }}" class="navbar-item {{ request()->is('/admin/posts') ? 'is-active' : '' }}">Admin</a>
                @endauth
                <a href="{{ route('home') }}" class="navbar-item {{ request()->is('/') ? 'is-active' : '' }}">Home</a>
                <a href="{{ route('posts.index') }}" class="navbar-item {{ request()->is('posts') ? 'is-active' : '' }}">Blog</a>
                <a href="{{ route('projects.index') }}" class="navbar-item {{ request()->is('projects') ? 'is-active' : '' }}">Open Source</a>
                <a href="{{ route('about-me') }}" class="navbar-item {{ request()->is('/about') ? 'is-active' : '' }}">About me</a>
                <div class="navbar-item">
                    <contact-modal>
                        <div class="button is-rounded is-info contact-me-button">Contact me</div>
                    </contact-modal>
                </div>
            </div>
        </div>
    </div>
</nav>
