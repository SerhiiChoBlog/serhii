<div class="navbar-menu z-40" id="navbar-menu">
    @foreach ($getMenuItems() as $item)
        <a
            href="{{ $item['href'] }}"
            class="relative first:rounded-t-lg border-b border-border lg:border-none text-sm before:content-none px-7 py-5 lg:p-0 lg:before:content-[''] navbar-link {{ $item['class'] }} uppercase drop-shadow-md"
            aria-label="{{ $item['title'] }}"
        >
            {{ $item['title'] }}
        </a>
    @endforeach

    <a
        href="{{ route('login') }}"
        class="relative first:rounded-t-lg border-b border-border lg:border-none text-sm before:content-none px-7 py-5 lg:p-0 lg:before:content-[''] navbar-link uppercase drop-shadow-md"
        aria-label="Login"
    >
        Account
    </a>

    <div class="min-w-[35px] mx-auto">
        <theme-switch theme="{{ request()->cookie('theme', 'system') }}" />
    </div>
</div>
