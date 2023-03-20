@php
    /**
     * @var array{name:string, id:int, color:string}[] $tags
     * @var array{name:string, id:int, color:string} $tag
     */
@endphp

<div>
    <div class="min-h-[36px] mt-4 lg:mt-6 flex justify-center items-center flex-wrap gap-3 lg:gap-5">
        @foreach ($tags as $tag)
            <a
                href="/posts?tag={{ $tag['name'] }}"
                class="text-[.9em] lg:text-lg inline-flex items-center group px-1 relative text-white"
            >
                {{ $tag['name'] }}

                <div
                    style="background-color: {{ $tag['color'] }};"
                    class="w-full h-1 absolute inset-x-0 -bottom-1.5 rounded-full group-hover:bottom-0 transition-all"
                ></div>
            </a>
        @endforeach
    </div>
</div>
