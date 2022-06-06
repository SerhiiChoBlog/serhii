@php
    /** @var ?boolean $is_light */
@endphp

<nav class="{{ ($is_grey ?? false) ? 'bg-gray-300' : 'transparent' }}">
    <div class="container flex justify-between items-center min-h-[3.25rem]">
        <div class="flex items-center gap-x-1">
            <a href="{{ route('home') }}" class="text-xl">
                <span>SERHII<span class="text-main">CHO</span></span>
            </a>

            @auth
                <a href="{{ route('admin.dashboard') }}" class="text-lg">
                    <b>ADMIN</b>
                </a>
            @endauth

           <hamburger {{ ($is_light ?? false) ? ':is-light="true"' : '' }} />
        </div>

        <x-navbar-menu />
    </div>
</nav>
