@php
    /** @var array $post */
@endphp

<div
    class="flex flex-col gap-4 justify-between relative"
>
    <div class="absolute -top-1 -right-1 bg-red-700 text-white px-3 rounded-sm shadow-md">NEW</div>

    <img
        src="{{ $post['image_sm'] }}"
        alt="{{ $post['title'] }}"
        class="rounded-lg shadow-lg w-full"
        width="395"
        height="215"
    >

    <h2 class="text-2xl font-bold px-2">
        {{ $post['title'] }}
    </h2>

    <p class="text-lg px-2">
        {{ $post['intro'] }}
    </p>

    <a
        href="{{ route('posts.show', $post['slug']) }}"
        class="border border-border rounded-lg py-2 px-4 uppercase text-center transition-colors hover:text-main hover:border-main"
    >
        Read post
    </a>
</div>
