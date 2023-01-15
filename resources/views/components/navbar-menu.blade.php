@php
    /**
     * @var array<int, array<string, string>> $menu_items
     */
@endphp

<div class="navbar-menu z-40 pb-8 lg:pb-0 overflow-hidden" id="navbar-menu">
    @foreach ($menu_items as $item)
        <x-nav-link :href="$item['href']" :title="$item['title']" :class="$item['class']" />
    @endforeach

    <div class="min-w-[35px] mx-auto mt-5 lg:mt-0">
        <theme-switch theme="{{ request()->cookie('theme', 'system') }}" />
    </div>

    <div class="mx-auto lg:m-0 text-center mt-5">
        @auth
            <a
                href="{{ route('login') }}"
                class="flex items-center justify-center gap-4"
            >
                <img
                    src="https://s.gravatar.com/avatar/19fd901cd984f39cd970710568ec72e6?s=200"
                    alt="Profile picture"
                    width="200"
                    height="200"
                    class="rounded-full w-10 border border-white"
                />

                <div class="overflow-hidden overflow-ellipsis whitespace-nowrap max-w-[200px] text-lg">
                    {{ auth()->user()->name }}
                </div>
            </a>
        @else
            <a href="{{ route('login') }}" class="main-btn">
                Login
            </a>
        @endauth
    </div>
</div>
