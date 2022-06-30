<nav class="relative">
    <div class="container flex justify-between items-center min-h-[4rem]">
        <div class="flex items-center gap-x-1 w-full lg:w-auto">
            <a
                href="{{ route('home') }}"
                class="text-md font-bold transition-opacity hover:opacity-80 text-lato drop-shadow-[1px_1px_0_rgba(0,0,0,.4)]"
            >
                <span>SERHII</span>
                <span class="text-main-light">CHO</span>
            </a>

            @auth
                <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold opacity-40 transition-opacity hover:opacity-100">
                    dashboard
                </a>
            @endauth

            <hamburger :is-light="true"></hamburger>
        </div>

        <x-navbar-menu />
    </div>
</nav>
