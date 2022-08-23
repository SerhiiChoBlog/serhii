<nav class="relative z-20">
    <div class="container flex justify-between items-center min-h-[4rem]">
        <div class="flex items-center gap-x-1 w-full lg:w-auto">
            @unless (request()->is('/'))
                <a
                    tabindex="1"
                    href="{{ route('home') }}"
                    class="text-lg font-bold transition-opacity hover:opacity-80 text-lato drop-shadow-[1px_1px_0_rgba(0,0,0,.4)]"
                    aria-label="Visit main page"
                >
                    <div class="tracking-wide">
                        <span class="text-white">SERHII</span>
                        <span class="text-main-light">CHO</span>
                    </div>
                </a>

                @auth
                    <a href="/admin/dashboard" aria-hidden="true" tabindex="-1">admin</a>
                @endauth
            @endunless

            <hamburger :is-light="true"></hamburger>
        </div>

        <x-navbar-menu />
    </div>
</nav>
