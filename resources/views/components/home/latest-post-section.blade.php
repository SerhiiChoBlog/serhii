@php
    /** @var array|null $post */
@endphp

@if ($post)
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center mx-auto">
        <div class="relative">
            <div class="text-sm lg:text-md absolute -top-1 -right-1 bg-red-700 text-white px-3 rounded-sm shadow-md">NEW</div>

            <img
                src="{{ $post['image_sm'] }}"
                alt="{{ $post['title'] }}"
                class="rounded-lg shadow-lg w-full"
                width="331"
                height="180"
            >
        </div>

        <div class="flex flex-col gap-y-2 lg:px-2">
            <h2 class="text-lg lg:text-2xl font-bold">
                {{ $post['title'] }}
            </h2>

            <p class="text-md lg:text-lg">
                {{ $post['intro'] }}
            </p>

            <div class="mt-5 md:mt-0 text-right">
                <a
                    type="button"
                    href="{{ route('posts.show', $post['slug']) }}"
                    class="block md:inline-block font-bold border border-border rounded-lg py-2 px-14 uppercase text-center transition-colors hover:text-main hover:border-main mx-auto"
                >
                    Read post
                </a>
            </div>
        </div>
    </div>
@endif
