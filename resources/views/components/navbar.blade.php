<nav>
    <div class="container flex justify-between items-center min-h-[3.25rem]">
        <div class="flex items-center gap-x-1 w-full lg:w-auto">
            <a href="{{ route('home') }}" class="text-md transition-opacity hover:opacity-80">
                <span>SERHII<span class="text-main">CHO</span></span>
            </a>

            @auth
                <a href="{{ route('admin.dashboard') }}" class="text-md">
                    ADMIN
                </a>
            @endauth

            <hamburger :is-light="true"></hamburger>
        </div>

        <x-navbar-menu />
    </div>
</nav>
