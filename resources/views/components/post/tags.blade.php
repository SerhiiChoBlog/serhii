<div class="flex gap-x-[.3rem] gap-y-3 flex-wrap {{ $attributes->get('class') }}">
    @foreach ($tags as $tag)
        <div class="flex items-center px-4 py-1 rounded-full shadow-md"
            style="background-color: {{ $tag['color'] }}"
        >
            <span class="text-white font-semibold">
                {{ $tag['name'] }}
            </span>
        </div>
    @endforeach

    {{ $slot }}
</div>
