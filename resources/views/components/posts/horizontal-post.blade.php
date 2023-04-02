@php
    use App\Models\Post;
    use Illuminate\View\ComponentAttributeBag;

    /**
     * @var Post|array<string, mixed> $post
     * @var ComponentAttributeBag $attributes
     */
@endphp

<article class="{{ $attributes->getAttributes()['class'] ?? '' }}">
    <div
        class="flex flex-col lg:flex-row items-center gap-6 max-w-[550px] lg:max-w-full mx-auto relative">
        <a
            href="/posts/{{ $post->slug }}"
            class="block w-full lg:max-w-[300px] transition-transform hover:scale-105 duration-300"
            rel="noreferrer"
        >
            <img
                src="{{ asset($post->image_xs) }}"
                data-src="{{ asset($post->image_sm) }}"
                class="rounded-lg shadow-md shadow-[rgba(0,0,0,.2)] w-full"
                width="550"
                height="275"
                alt="Main image for the post '{{ $post->title }}'"
            />
        </a>

        <div>
            <div>
                <a href="/posts/{{ $post->slug }}" rel="noreferrer" class="text-font hover:underline">
                    <h2 class="text-2xl mb-1">
                        @if ($post->series->isNotEmpty())
                            {{ $post->series->first()->title }}:
                        @endif

                        {{ $post->title }}
                    </h2>
                </a>

                <x-posts.series-number :post="$post" />

                <p class="mt-1 text-lg font-light text-font-second font-post">
                    {{ $post->intro }}
                </p>
            </div>

            <div>
                <x-post.tags :tags="$post->tags" class="text-[.8em] mt-3" />
                <x-post.details :post="$post" class="mt-3">
                    @if (auth('admin')->check())
                        <x-edit-button url="/admin/posts/{{ $post->id }}/edit" />
                    @endif
                </x-post.details>
            </div>
        </div>
    </div>
</article>
