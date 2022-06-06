<div class="flex items-center gap-x-6" id="navbar-menu">
    @foreach ($getMenuItems() as $item)
        <a href="{{ $item['href'] }}"
           class="relative text-md navbar-link {{ $item['class'] }}"
        >{{ $item['title'] }}</a>
    @endforeach

    <div>
        <contact-modal>
            <div class="rounded-full bg-main">Contact me</div>
        </contact-modal>
    </div>
    <div>
        <theme-switch theme="{{ request()->cookie('theme') ?? 'light' }}" />
    </div>
</div>
