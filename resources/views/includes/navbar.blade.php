@php
    /** @var ?boolean $is_light */
@endphp

<nav class="{{ ($is_grey ?? false) ? 'bg-gray-300' : 'transparent' }}">
    <div class="container flex justify-between">
        <div class="navbar-brand">
            <a href="{{ route('home') }}" class="relative text-xl text-white">
                <b>SERHII<span class="text-main-light">CHO</span></b>
            </a>

            @auth
                <a href="{{ route('admin.dashboard') }}" class="navbar-item" style="margin-left: -17px">
                    <b>ADMIN</b>
                </a>
            @endauth

           <hamburger {{ ($is_light ?? false) ? ':is-light="true"' : '' }} />
        </div>

        <div class="flex " id="navbar-menu">
            <a href="{{ route('home') }}" class="navbar-item has-stripe {{ request()->is('/') ? 'is-active' : '' }}">Home</a>
            <a href="{{ route('posts.index') }}" class="navbar-item has-stripe {{ request()->is('posts') ? 'is-active' : '' }}">Blog</a>
            <a href="{{ route('projects.index') }}" class="navbar-item has-stripe {{ request()->is('projects') ? 'is-active' : '' }}">Open Source</a>
            <a href="{{ route('about-me') }}" class="navbar-item has-stripe {{ request()->is('about-me') ? 'is-active' : '' }}">About me</a>

            <div class="navbar-item">
                <contact-modal>
                    <div class="button is-rounded is-info contact-me-button">Contact me</div>
                </contact-modal>
            </div>
            <div class="navbar-item">
                <theme-switch theme="{{ request()->cookie('theme') ?? 'light' }}" />
            </div>
        </div>
    </div>
</nav>
