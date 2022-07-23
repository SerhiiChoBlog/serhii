@php
    /**
     * @var array<int, array{title:string, href:string}> $tabs
     */
@endphp

<div class="flex gap-4 justify-center pb-7">
    @foreach ($tabs as $tab)
        <a
            href="{{ $tab['href'] }}"
            class="_tab px-3 py-2 bg-main text-white rounded-lg"
        >
            {{ $tab['title'] }}
        </a>
    @endforeach
</div>