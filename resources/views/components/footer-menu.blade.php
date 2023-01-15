@php
    /**
     * @var array<int, array<string, string>> $menu_items
     */
@endphp

<ul>
    @foreach($menu_items as $item)
        <li>
            <a
                href="{{ $item['href'] }}"
                class="relative first:rounded-t-lg border-b border-border lg:border-none text-sm before:content-none px-7 py-5 lg:p-0 lg:before:content-[''] navbar-link {{ $item['class'] }} uppercase drop-shadow-md"
                aria-label="{{ $item['title'] }}"
            >
                {{ $item['title'] }}
            </a>
        </li>
    @endforeach
</ul>
