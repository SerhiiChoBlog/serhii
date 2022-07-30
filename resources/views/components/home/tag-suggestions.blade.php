@php
    /**
     * @var callable $getTags
     * @var array{name:string, id:int, color:string} $tag
     */
@endphp

<div>
    <div class="min-h-[36px] mt-4 lg:mt-6 text-white flex justify-center items-center flex-wrap gap-1 lg:gap-3">
        @foreach ($getTags() as $tag)
            <a
                href="/posts?tag={{ $tag['name'] }}"
                class="text-[.8em] lg:text-lg inline-flex items-center p-1 transition-transform hover:scale-110"
            >
                <b style="color: {{ $tag['color'] }}">&#x25C9;</b>
                <span class="ml-1 lg:ml-2">{{ $tag['name'] }}</span>
            </a>
        @endforeach
    </div>
</div>
