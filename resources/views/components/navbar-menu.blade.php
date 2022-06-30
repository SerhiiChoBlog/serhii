<div class="navbar-menu" id="navbar-menu">
    @foreach ($getMenuItems() as $item)
        <a
            href="{{ $item['href'] }}"
            class="relative text-md before:content-none px-7 py-5 lg:p-0 lg:before:content-[''] navbar-link {{ $item['class'] }}"
            aria-label="{{ $item['title'] }}"
        >
            {{ $item['title'] }}
        </a>
    @endforeach

    <contact-modal>
        <div class="border py-2 px-6 rounded-full">Contact me</div>
    </contact-modal>

    <div class="min-w-[35px]">
        <theme-switch theme="{{ request()->cookie('theme') ?? 'light' }}" />
    </div>
</div>
