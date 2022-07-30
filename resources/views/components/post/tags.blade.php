<div class="flex gap-1 flex-wrap {{ $attributes->get('class') }}">
    @foreach ($tags as $tag)
        <tip content="{{ $tag['title'] }}">
            <a href="/posts?tag={{ $tag['name'] }}" class="">
                <span
                    class="inline-flex items-center px-3 py-0.5 rounded-md text-xs font-bold leading-5 text-white bg-brand-500 transition-transform hover:scale-105 duration-300"
                    style="background-color: {{ $tag['color'] }}"
                >
                    {{ $tag['name'] }}
                </span>
            </a>
        </tip>
    @endforeach
</div>
