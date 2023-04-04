@php
    use App\Models\Post;

    /**
     * @var Post|array<string, mixed> $post
     */
@endphp

<article class="max-w-md mx-auto">
    <a
        href="{{ route('posts.show', $post->slug) }}"
        class="transition-opacity hover:opacity-70"
    >
        <img
            src="{{ asset($post->image_xs) }}"
            data-src="{{ asset($post->image_sm) }}"
            alt="Main image for the post '{{ $post->title }}'"
            class="rounded-md shadow-md mx-auto w-full"
            width="500"
            height="275"
        />
    </a>

    <div class="py-5 px-2">
        <h2 class="text-xl font-semibold mb-2">
            @if ($post->series->isNotEmpty())
                {{ $post->series->first()->title }}:
            @endif

            {{ $post->title }}
        </h2>

        <x-posts.series-number :post="$post" />

        <p class="mt-2 text-md text-font-second">{{ $post->intro }}</p>

        <x-post.tags :tags="$post->tags" class="text-[.8em] mt-4" />
        <x-post.details :post="$post" class="mt-3">
            <x-edit-button url="/admin/posts/{{ $post->id }}/edit" />
        </x-post.details>
    </div>
</article>
