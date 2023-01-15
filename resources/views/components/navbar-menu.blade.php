@php
    /**
     * @var array<int, array<string, string>> $menu_items
     */
@endphp

<div class="navbar-menu z-40" id="navbar-menu">
    @foreach ($menu_items as $item)
        <x-nav-link :href="$item['href']" :title="$item['title']" :class="$item['class']" />
    @endforeach

    <div class="min-w-[35px] mx-auto">
        <theme-switch theme="{{ request()->cookie('theme', 'system') }}" />
    </div>

    <div class="p-7 lg:p-0 text-center">
        @auth
            <a href="{{ route('login') }}">
                <img
                    src="https://s.gravatar.com/avatar/19fd901cd984f39cd970710568ec72e6?s=200"
                    alt="Profile picture"
                    width="200"
                    height="200"
                    class="rounded-full w-10 border border-white"
                />
            </a>
        @else
            <a href="{{ route('login') }}" class="main-btn">
                Login
            </a>
        @endauth
    </div>
</div>
