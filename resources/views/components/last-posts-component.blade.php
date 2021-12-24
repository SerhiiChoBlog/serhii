@php
    /** @var array[] $posts */
@endphp

<div class="last-posts">
    <h2 class="home__title has-text-centered">Lastest posts</h2>

    <div class="columns">
        @foreach ($posts as $post)
            <div class="column">
                <div>
                    <a href="{{ route('posts.show', $post['slug']) }}" class="card-image">
                        <img data-src="{{ asset($post['image_sm']) }}" alt="{{ $post['title'] }}" class="smooth-loader">
                    </a>
                    <div class="card-content">
                        <div class="media mb-3">
                            <div class="media-content">
                                <p class="title is-4 has-text-weight-bold">{{ $post['title'] }}</p>
                            </div>
                        </div>

                        <div class="content is-medium mb-2">{{ $post['intro'] }}</div>

                        <div class="tags mt-3">
                            @foreach ($post['tags'] as $tag)
                                <span class="tag my-0 is-small is-normal is-dark mb-1" style="background-color: {{ $tag['color'] }}">
                                    {{ $tag['name'] }}
                                </span>
                            @endforeach
                            <time datetime="{{ $post['created_at'] }}" class="has-text-grey mb-1">{{ $post['pretty_created_at'] }}</time>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
