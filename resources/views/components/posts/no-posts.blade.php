@if (request()->has('tag'))
    <h2 class="text-center text-xl mt-10">
        There are no posts with the tag
        <strong class="text-font-second">"{{ request('tag') }}"</strong>
    </h2>
@else
    <h2 class="text-center text-xl mt-20">
        There are no posts found
    </h2>
@endif

<div class="flex gap-3 justify-center mt-5 mb-20">
    @foreach (['/' => 'Go home', '/posts' => 'All posts'] as $url => $title)
        <a
            href="{{ $url }}"
            rel="noreferrer"
            class="px-10 py-2 border border-border rounded-full uppercase"
        >
            {{ $title }}
        </a>
    @endforeach
</div>
