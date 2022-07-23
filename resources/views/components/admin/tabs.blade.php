@php
    /**
     * @var array<int, array{title:string, href:string}> $tabs
     */
@endphp

<div class="flex gap-5 justify-center pb-7">
    @foreach ($tabs as $tab)
        <a
            href="{{ $tab['href'] }}"
            class="_tab px-2 py-1 border-b-4 text-gray-500 transition-colors hover:border-b-gray-400 hover:text-gray-700 rounded-sm text-md"
        >
            {{ $tab['title'] }}
        </a>
    @endforeach
</div>