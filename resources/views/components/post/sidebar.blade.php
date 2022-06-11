<div class="pt-10 lg:pt-16">
    <div class="hidden lg:block">
        <nav class="min-h-[83px] mb-7">
            <x-post.sidebar-title>Share this post</x-post.sidebar-title>
            <share-post-buttons post-title="{{ $post['title'] }}" :post-id="{{ $post['id'] }}" />
        </nav>

        <nav class="mb-7">
            <x-post.sidebar-title>Chapters</x-post.sidebar-title>
            <chapters />
        </nav>
    </div>

    <nav class="mb-7">
        <x-post.sidebar-title>Other posts</x-post.sidebar-title>

        <div class="flex flex-col gap-y-2">
            @foreach ($posts as $other_post)
                <a href="{{ route('posts.show', $other_post) }}" class="p-2 transition-opacity hover:opacity-80">
                    <img data-src="{{ asset($other_post->image_sm) }}"
                         alt="{{ $other_post->title }}"
                         class="smooth-loader rounded-lg shadow-lg"
                    >
                    <h4 class="text-lg leading-6 my-3">{{ $other_post->title }}</h4>
                </a>
            @endforeach
        </div>
    </nav>
</div>
