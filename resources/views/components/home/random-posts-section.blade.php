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

                <p class="mt-3 mb-4 text-lg">{{ $post['intro'] }}</p>

                <x-post.tags :tags="$post['tags']" class="text-xs">
                    <x-post.created :created="$post['created_at']" :pretty="$post['pretty_created_at']" />
                </x-post.tags>
            </div>
        </article>
    @endforeach
</div>

<div class="mt-8 text-center">
    <x-button :href="route('posts.index')">
        Go to posts
    </x-button>
</div>
