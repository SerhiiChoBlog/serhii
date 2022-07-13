@php
    /** @var array|null $post */
@endphp

@if ($post)
    <article class="mx-auto">
        <a
            href="{{ route('posts.show', $post['slug']) }}"
            class="flex flex-col md:flex-row gap-4 justify-between items-center"
        >
            <div class="relative">
                <div class="text-sm lg:text-md absolute z-10 -top-1 -right-1 bg-red-700 text-white px-3 rounded-sm shadow-md">NEW</div>

                <img
                    data-src="{{ $post['image_sm'] }}"
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

                <x-post.tags :tags="$post['tags']" class="text-sm md:text-md mt-2" />
                <x-post.details :post="$post" class="mt-1" />
            </div>
        </a>
    </article>
@endif
