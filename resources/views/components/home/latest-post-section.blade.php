@php
    /** @var array|null $post */
@endphp

@if ($post)
    <article class="flex flex-col md:flex-row gap-4 justify-between items-center mx-auto">
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

            <x-post.tags :tags="$post['tags']" class="text-sm md:text-md">
                <x-post.created :created="$post['created_at']" :pretty="$post['pretty_created_at']" />
            </x-post.tags>

            <div class="mt-5 md:mt-0 text-right">
                <x-button :href="route('posts.show', $post['slug'])">
                    Read post
                </x-button>
            </div>
        </div>
    </article>
@endif
