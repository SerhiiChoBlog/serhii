@php
    /** @var array $posts */
@endphp

<div class="divide-y divide-border">
    @foreach($posts as $post)
        <article class="px-4 mx-auto pt-8 pb-5">
            <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
                <div class="relative">
                    <x-image-label>New</x-image-label>

                    <a href="{{ route('posts.show', $post['slug']) }}">
                        <img
                            src="{{ $post['image_xs'] }}"
                            data-src="{{ $post['image_sm'] }}"
                            alt="Main image for the post '{{ $post['title'] }}'"
                            class="rounded-lg shadow-lg w-full min-w-[350px] max-w-[400px]"
                            width="331"
                            height="180"
                        >
                    </a>
                </div>

                <div class="flex flex-col gap-y-2 lg:px-2">
                    <a href="{{ route('posts.show', $post['slug']) }}">
                        <h2 class="text-lg lg:text-2xl font-bold">
                            {{ $post['title'] }}
                        </h2>

                        <p class="text-md lg:text-lg font-post">
                            {{ $post['intro'] }}
                        </p>
                    </a>

                    <x-post.tags :tags="$post['tags']" class="text-sm md:text-md mt-2 !gap-2" />
                    <x-post.details :post="$post" class="mt-1" />
                </div>
            </div>
        </article>
    @endforeach
</div>
