@php
    /** @var array[] $posts */
@endphp

<div>
    <x-home.section-title>Latest posts</x-home.section-title>

    <div class="flex gap-8">
        @foreach ($posts as $post)
            <div>
                <div>
                    <a href="{{ route('posts.show', $post['slug']) }}">
                        <img data-src="{{ asset($post['image_sm']) }}"
                            alt="{{ $post['title'] }}"
                            class="smooth-loader"
                        />
                    </a>
                    <div class="card-content">
                        <div class="media mb-3">
                            <div class="media-content">
                                <p class="title is-4 has-text-weight-bold">{{ $post['title'] }}</p>
                            </div>
                        </div>

                        <div class="content is-medium mb-2">{{ $post['intro'] }}</div>

                        <x-post.tags :tags="$post['tags']" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
