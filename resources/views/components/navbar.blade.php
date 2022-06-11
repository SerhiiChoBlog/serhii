<nav>
    <div class="container flex justify-between items-center min-h-[3.25rem]">
        <div class="flex items-center gap-x-1 w-full">
            <a href="{{ route('home') }}" class="text-xl transition-opacity hover:opacity-80">
                <span>SERHII<span class="text-main">CHO</span></span>
            </a>

            @auth
                <a href="{{ route('admin.dashboard') }}" class="text-lg">
                    <b>ADMIN</b>
                </a>
            @endauth

            <hamburger :is-light="true"></hamburger>
        </div>

        <x-navbar-menu />
    </div>
</nav>
