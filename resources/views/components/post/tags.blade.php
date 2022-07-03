<ul class="flex gap-x-[.3rem] gap-y-3 flex-wrap {{ $attributes->get('class') }}">
    @foreach ($tags as $tag)
        <li class="flex items-center px-2 py-[2px] rounded-md"
            style="background-color: {{ $tag['color'] }}"
        >
            <span class="text-white font-semibold">
                {{ $tag['name'] }}
            </span>
        </li>
    @endforeach

    {{ $slot }}
</ul>
