@php
    /**
     * @var array<int, array<string, string>> $menu_items
     */
@endphp

<div class="navbar-menu z-40 pb-8 lg:pb-0" id="navbar-menu">
    @foreach ($menu_items as $item)
        <x-nav-link :href="$item['href']" :title="$item['title']" :class="$item['class']" />
    @endforeach

    <div class="min-w-[35px] mx-auto mt-5 lg:mt-0">
        <theme-switch theme="{{ request()->cookie('theme', 'system') }}" />
    </div>

    <div class="mx-auto lg:m-0 text-center mt-5">
        @if (user())
            <a
                href="{{ auth('user')->check() ? route('user.profile.show') : '/admin/dashboard' }}"
                class="flex items-center justify-center gap-4 bg-black/20 rounded-full pl-5 hover:bg-black/40 transition-colors group"
                rel="noreferrer"
            >
                <div class="overflow-hidden overflow-ellipsis whitespace-nowrap max-w-[150px] text-lg">
                    {{ user()->name }}
                </div>

                <img
                    src="{{ asset(sprintf('storage/avatars/%s', user()->avatar)) }}"
                    alt="Profile picture"
                    width="200"
                    height="200"
                    class="rounded-full w-10 h-10 border border-white shadow-md group-hover:shadow-lg"
                />
            </a>
        @else
            <a
                href="{{ request()->is('login') ? route('register') : route('login') }}"
                class="main-btn min-w-[140px]"
                rel="noreferrer"
            >
                {{ request()->is('login') ? 'Register' : 'Login' }}
            </a>
        @endif
    </div>
</div>
