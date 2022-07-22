@php
    use Serhii\Ago\TimeAgo;

    /** @var array|null $post */
@endphp

@if ($post)
    <article class="mx-auto">
        <div
            class="flex flex-col md:flex-row gap-4 justify-between items-center"
        >
            <div class="relative">
                <x-image-label>In progress</x-image-label>

                <img
                    data-src="{{ $post['image_sm'] }}"
                    alt="{{ $post['title'] }}"
                    class="rounded-lg shadow-lg w-full"
                    width="331"
                    height="180"
                >
            </div>

            <div class="flex flex-col gap-y-2 lg:px-2">
                <h2 class="text-lg lg:text-2xl font-bold">
                    {{ $post['title'] }}

                    @if (auth()->check())
                        <a
                            href="{{ route('admin.posts.edit', ['post' => $post['id']]) }}"
                            class="px-3 ml-1 tracking-wider border border-font-second border-dashed rounded-full transition-opacity hover:opacity-80 py-1 uppercase text-xs"
                        >
                            Edit
                        </a>
                    @endif
                </h2>

                <p class="text-md lg:text-lg font-post">
                    {{ $post['intro'] }}
                </p>

                <x-post.tags :tags="$post['tags']" class="text-sm md:text-md mt-2 !gap-2" />

                <div class="opacity-70 flex items-center gap-2">
                    <span>Last update on the post:</span>

                    <time datetime="{{ $post['updated_at'] }}" class="font-bold">
                        {{ TimeAgo::trans($post['updated_at']) }}
                    </time>
                </div>
            </div>
        </div>
    </article>
@else
    <h2 class="text-center text-2xl">
        🤔 There is no post yet, I'm thinking what to write next
    </h2>
@endif
