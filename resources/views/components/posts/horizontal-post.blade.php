@php
    use App\Models\Post;
    use Illuminate\View\ComponentAttributeBag;

    /**
     * @var array{id: int, slug: string, title: string, intro: string, image_sm: string, tags: array}|Post $post
     * @var ComponentAttributeBag $attributes
     */
@endphp

<article class="{{ $attributes->getAttributes()['class'] ?? '' }}">
    <div
        class="flex flex-col lg:flex-row items-center gap-6 border-md p-3 rounded-xl max-w-[550px] lg:max-w-full mx-auto transition-colors hover:bg-page-second relative">
        <a
            href="/posts/{{ $post->slug ?? $post['slug'] }}"
            class="block w-full lg:max-w-[300px]"
            rel="noreferrer"
        >
            <img
                src="{{ asset($post->image_xs ?? $post['image_xs']) }}"
                data-src="{{ asset($post->image_sm ?? $post['image_sm']) }}"
                class="rounded-lg shadow-md shadow-[rgba(0,0,0,.2)] w-full"
                width="550"
                height="275"
                alt="Main image for the post '{{ $post->title ?? $post['title'] }}'"
            />
        </a>

        <div>
            <a href="/posts/{{ $post->slug ?? $post['slug'] }}" rel="noreferrer">
                <h2 class="text-2xl text-font">{{ $post->title ?? $post['title'] }}</h2>
                <p class="mt-2 text-lg font-light text-font-second font-post">{{ $post->intro ?? $post['intro'] }}</p>
            </a>

            <div>
                <x-post.tags :tags="$post->tags ?? $post['tags']" class="text-[.8em] mt-3"/>
                <x-post.details :post="is_array($post) ? $post : $post->toArray()" class="mt-3"/>
            </div>
        </div>

        <x-posts.comments-amount
            class="absolute bottom-4 right-4 text-font-second opacity-60"
            :amount="$post->comments_count ?? $post['comments_count']"
        />
    </div>
</article>
