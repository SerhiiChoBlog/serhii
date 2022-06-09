<div class="flex gap-2 flex-wrap {{ $attributes->get('class') }}">
    @foreach ($tags as $tag)
        <span class="flex items-center px-2 py-1 rounded-[4px] text-white"
            style="background-color: {{ $tag['color'] }}"
        >
            {{ $tag['name'] }}
        </span>
    @endforeach

    {{ $slot }}
</div>
