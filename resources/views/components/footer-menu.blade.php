@php
    /**
     * @var array<int, array<string, string>> $menu_items
     */
@endphp

<div class="flex flex-col items-center xl:items-start gap-3 mt-10 xl:mt-0">
    @foreach($menu_items as $item)
        <a
            href="{{ $item['href'] }}"
            class="{{ $item['class'] }} uppercase"
            rel="noreferrer"
        >
            {{ $item['title'] }}
        </a>
    @endforeach

    <div class="mt-2">
        <contact-modal></contact-modal>
    </div>
</div>
