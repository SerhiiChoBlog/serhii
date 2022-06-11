@php
    /** @var array[] $posts */
@endphp

<div>
    <x-home.section-title>Latest posts</x-home.section-title>

    <div class="flex flex-col lg:flex-row gap-8">
        @foreach ($posts as $post)
            <div>
                <a href="{{ route('posts.show', $post['slug']) }}"
                   class="transition-opacity hover:opacity-70"
                >
                    <img data-src="{{ asset($post['image_sm']) }}"
                        alt="{{ $post['title'] }}"
                        class="smooth-loader rounded-md shadow-md mx-auto"
                    />
                </a>

                <div class="py-5 px-2">
                    <h4 class="text-2xl font-medium">{{ $post['title'] }}</h4>

                    <p class="my-3 text-lg font-light">{{ $post['intro'] }}</p>

                    <x-post.tags :tags="$post['tags']" class="text-xs" />
                </div>
            </div>
        @endforeach
    </div>
</div>
