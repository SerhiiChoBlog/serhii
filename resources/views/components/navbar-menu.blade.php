<div class="navbar-menu" id="navbar-menu">
    @foreach ($getMenuItems() as $item)
        <a href="{{ $item['href'] }}"
           class="relative text-md before:content-none px-7 py-5 lg:p-0 lg:before:content-[''] navbar-link {{ $item['class'] }}"
        >{{ $item['title'] }}</a>
    @endforeach

    <div>
        <contact-modal>
            <div class="bg-main py-2 px-6 rounded-full">Contact me</div>
        </contact-modal>
    </div>

    <div>
        <theme-switch theme="{{ request()->cookie('theme') ?? 'light' }}" />
    </div>
</div>
