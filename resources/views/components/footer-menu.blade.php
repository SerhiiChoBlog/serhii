@php
    /**
     * @var array<int, array<string, string>> $menu_items
     */
@endphp

<div class="flex flex-col items-center xl:items-start gap-3 mt-10 xl:mt-0">
    @foreach($menu_items as $item)
        <x-nav-link
            :href="$item['href']"
            :title="$item['title']"
            :class="$item['class']"
        />
    @endforeach

    <div class="xl:mt-2">
        <contact-modal></contact-modal>
    </div>
</div>
