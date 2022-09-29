@php
    /**
     * @var array{id: int, slug: string, title: string, intro: string, image_sm: string, tags: array} $post
     */
@endphp

<article class="max-w-md mx-auto">
    <a
        href="{{ route('posts.show', $post['slug']) }}"
        class="transition-opacity hover:opacity-70"
    >
        <img
            data-src="{{ asset($post['image_sm']) }}"
            alt="Main image for the post '{{ $post['title'] }}'"
            class="rounded-md shadow-md mx-auto w-full"
            width="500"
            height="275"
        />
    </a>

    <div class="py-5 px-2">
        <h3 class="text-2xl font-semibold">{{ $post['title'] }}</h3>

        <p class="mt-3 text-lg font-post">{{ $post['intro'] }}</p>

        <x-post.tags :tags="$post['tags']" class="text-[.8em] mt-4" />
        <x-post.details :post="$post" class="mt-3" />
    </div>
</article>
