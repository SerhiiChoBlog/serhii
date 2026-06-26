@php
    use App\Models\Badge;
    use Illuminate\Support\Collection;

    /**
    * @var Collection<int, Badge> $badges
    */
@endphp

<div class="mt-4 pt-4 border-t border-border">
    <h2 class="text-xl font-bold">Achievements</h2>

    <div class="flex flex-wrap gap-0.5 mt-3">
        @if ($badges->isEmpty())
            <span class="text-lg text-font-second">
            😔 No badges yet
            </span>
        @else
            @foreach ($badges as $badge)
                <tip content="{{ $badge->description }}" class="w-16">
                    <img
                        src="/img/badges/{{ $badge->icon }}"
                        alt="`Badge for {{ $badge->name }}`"
                        width="270"
                        height="270"
                        class="drop-shadow-md pointer-events-none"
                    />
                </tip>
            @endforeach
        @endif
    </div>
</div>
