@php
    use App\Models\Post;

    /**
     * @var array{id: int, slug: string, title: string, intro: string, image_sm: string, tags: array}|Post $post
     * @var bool $lazy
     */
@endphp

<article {{ $attributes->class([]) }}>
    <div
        class="flex flex-col lg:flex-row items-center gap-6 border-md p-3 rounded-xl max-w-[550px] lg:max-w-full mx-auto transition-colors hover:bg-page-second">
        <a href="/posts/{{ $post->slug ?? $post['slug'] }}" class="block w-full max-w-max lg:max-w-[300px]">
            <img
                @if ($lazy)
                    data-src="{{ asset($post->image_sm ?? $post['image_sm']) }}"
                @else
                    src="{{ asset($post->image_sm ?? $post['image_sm']) }}"
                @endif
                class="rounded-lg shadow-md shadow-[rgba(0,0,0,.2)] w-full"
                width="550"
                height="275"
                alt="Main image for the post '{{ $post->title ?? $post['title'] }}'"
            />
        </a>

        <div>
            <a href="/posts/{{ $post->slug ?? $post['slug'] }}">
                <h2 class="text-2xl text-font">{{ $post->title ?? $post['title'] }}</h2>
                <p class="mt-2 text-lg font-light text-font-second font-post">{{ $post->intro ?? $post['intro'] }}</p>
            </a>

            <div>
                <x-post.tags :tags="$post->tags ?? $post['tags']" class="text-[.8em] mt-3"/>
                <x-post.details :post="is_array($post) ? $post : $post->toArray()" class="mt-3"/>
            </div>
        </div>
    </div>
</article>
