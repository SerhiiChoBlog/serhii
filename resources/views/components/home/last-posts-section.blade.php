@php
    /** @var array[] $posts */
@endphp

<div>
    <div class="flex flex-col lg:flex-row gap-8">
        @foreach ($posts as $post)
            <article class="max-w-md mx-auto">
                <a
                    href="{{ route('posts.show', $post['slug']) }}"
                    class="transition-opacity hover:opacity-70"
                >
                    <img
                        data-src="{{ asset($post['image_sm']) }}"
                        alt="{{ $post['title'] }}"
                        class="smooth-loader rounded-md shadow-md mx-auto"
                        width="468"
                        height="255"
                    />
                </a>

                <div class="py-5 px-2">
                    <h3 class="text-2xl font-medium font-arizona">{{ $post['title'] }}</h3>

                    <p class="my-3 text-lg font-light">{{ $post['intro'] }}</p>

                    <x-post.tags :tags="$post['tags']" class="text-xs">
                        <x-post.created :created="$post['created_at']" :pretty="$post['pretty_created_at']" />
                    </x-post.tags>
                </div>
            </article>
        @endforeach
    </div>
</div>
