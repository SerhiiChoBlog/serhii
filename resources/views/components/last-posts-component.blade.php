@php
    /** @var array[] $posts */
@endphp

<div>
    <h2 class="home__title has-text-centered">Last posts</h2>

    <div class="columns">
        @foreach ($posts as $post)
            <div class="column">
                <a href="{{ route('posts.show', $post['slug']) }}" class="card">
                    <div class="card-image">
                        <img data-src="{{ asset($post['image_sm']) }}" alt="{{ $post['title'] }}" class="smooth-loader">
                    </div>
                    <div class="card-content">
                        <div class="media">
                            <div class="media-content">
                                <p class="title is-4">{{ $post['title'] }}</p>
                            </div>
                        </div>

                        <div class="content">{{ $post['intro'] }}</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
