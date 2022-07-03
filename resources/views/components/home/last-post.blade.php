@php
    /** @var array $post */
@endphp

<a
    href="{{ route('posts.show', $post['slug']) }}"
    class="flex flex-col sm:flex-row lg:flex-col gap-4 justify-between items-center max-w-[420px] sm:max-w-full mx-auto"
>
    <div class="relative">
        <div class="text-sm lg:text-md absolute -top-1 -right-1 bg-red-700 text-white px-3 rounded-sm shadow-md">NEW</div>

        <img
            src="{{ $post['image_sm'] }}"
            alt="{{ $post['title'] }}"
            class="rounded-lg shadow-lg w-full"
            width="395"
            height="215"
        >
    </div>

    <div class="flex flex-col gap-y-2 lg:px-2">
        <h2 class="text-lg lg:text-2xl font-bold">
            {{ $post['title'] }}
        </h2>

        <p class="text-md lg:text-lg">
            {{ $post['intro'] }}
        </p>
    </div>

    <button
        type="button"
        class="block sm:hidden lg:block w-full border border-border rounded-lg py-2 px-4 uppercase text-center transition-colors hover:text-main hover:border-main"
    >
        Read post
    </button>
</a>
