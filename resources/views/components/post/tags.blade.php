<div class="flex gap-1 flex-wrap {{ $attributes->get('class') }}">
    @foreach ($tags as $tag)
        <span>
            <span
                class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-bold leading-5 text-white capitalize bg-brand-500"
                style="background-color: {{ $tag['color'] }}"
            >
                {{ $tag['name'] }}
            </span>
        </span>
    @endforeach
</div>
