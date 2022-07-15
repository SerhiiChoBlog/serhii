@php
    /** @var array[] $posts */
@endphp

<div class="flex flex-col lg:flex-row gap-8 overflow-x-hidden">
    @foreach ($posts as $post)
        <article class="max-w-md mx-auto">
            <a
                href="{{ route('posts.show', $post['slug']) }}"
                class="transition-opacity hover:opacity-70"
            >
                <img
                    data-src="{{ asset($post['image_sm']) }}"
                    alt="{{ $post['title'] }}"
                    class="rounded-md shadow-md mx-auto"
                    width="468"
                    height="255"
                />
            </a>

            <div class="py-5 px-2">
                <h3 class="text-2xl font-semibold">{{ $post['title'] }}</h3>

                <p class="mt-3 text-lg font-post">{{ $post['intro'] }}</p>

                <x-post.tags :tags="$post['tags']" class="text-[.8em] mt-4" />
                <x-post.details :post="$post" class="mt-3" />
            </div>
        </article>
    @endforeach
</div>
