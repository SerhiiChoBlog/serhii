@php
    /**
     * @var array<int, array<string, string>> $menu_items
     */
@endphp

<div class="flex flex-col items-center xl:items-start gap-3 mt-10 xl:mt-0">
    @foreach($menu_items as $item)
        @if ($item['is_active'])
            <span class="{{ $item['is_active'] ? 'border-b-2 border-white' : '' }} uppercase">
                {{ $item['title'] }}
            </span>

        @else
            <a
                href="{{ $item['href'] }}"
                class="{{ $item['is_active'] ? 'border-b-2 border-white' : '' }} uppercase"
                rel="noreferrer"
            >
                {{ $item['title'] }}
            </a>
        @endif
    @endforeach

    <div class="mt-2">
        <contact-modal></contact-modal>
    </div>
</div>
