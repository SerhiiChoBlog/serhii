<div class="flex gap-2">
    @foreach ($tags as $tag)
        <span class="px-2 py-1 rounded-[4px] text-white text-xs" style="background-color: {{ $tag['color'] }}">
            {{ $tag['name'] }}
        </span>
    @endforeach
</div>
