<div class="navbar-menu" id="navbar-menu">
    @foreach ($getMenuItems() as $item)
        <a
            href="{{ $item['href'] }}"
            class="relative text-sm before:content-none px-7 py-5 lg:p-0 lg:before:content-[''] navbar-link {{ $item['class'] }} uppercase"
            aria-label="{{ $item['title'] }}"
        >
            {{ $item['title'] }}
        </a>
    @endforeach

    <contact-modal>
        <div class="w-full mx-auto shadow-md border border-border max-w-xs bg-main lg:w-auto font-semibold text-white py-2 px-6 rounded-full transition-colors hover:bg-main-hover">Contact me</div>
    </contact-modal>

    <div class="min-w-[35px] mx-auto">
        <theme-switch theme="{{ request()->cookie('theme') ?? 'light' }}" />
    </div>
</div>
