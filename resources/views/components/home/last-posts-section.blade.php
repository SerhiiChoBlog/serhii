@php
    /** @var array[] $posts */
@endphp

<div>
    <x-home.section-title>Latest posts</x-home.section-title>

    <div class="flex gap-8">
        @foreach ($posts as $post)
            <div>
                <a href="{{ route('posts.show', $post['slug']) }}"
                   class="transition-opacity hover:opacity-70"
                >
                    <img data-src="{{ asset($post['image_sm']) }}"
                        alt="{{ $post['title'] }}"
                        class="smooth-loader rounded-md shadow-md"
                    />
                </a>

                <div class="py-5 px-2">
                    <h4 class="text-2xl font-light">{{ $post['title'] }}</h4>

                    <div class="my-3 text-lg text-light">{{ $post['intro'] }}</div>

                    <x-post.tags :tags="$post['tags']" />
                </div>
            </div>
        @endforeach
    </div>
</div>
