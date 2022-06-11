<div class="flex gap-x-2 gap-y-3 flex-wrap {{ $attributes->get('class') }}">
    @foreach ($tags as $tag)
        <span class="flex items-center px-3 py-1 rounded-[4px] text-white font-light shadow-md"
            style="background-color: {{ $tag['color'] }}"
        >
            {{ $tag['name'] }}
        </span>
    @endforeach

    {{ $slot }}
</div>
