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
                </h2>

                <p class="text-md lg:text-lg font-post">
                    {{ $post['intro'] }}
                </p>

                <x-post.tags :tags="$post['tags']" class="text-sm md:text-md mt-2" />

                <div class="opacity-70 flex items-center gap-2">
                    <span>Last update on the post:</span>

                    <time datetime="{{ $post['updated_at'] }}" class="font-bold">
                        {{ TimeAgo::trans($post['updated_at']) }}
                    </time>
                </div>
            </div>
        </div>
    </article>
@endif
