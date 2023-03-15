@php
    use Serhii\Ago\TimeAgo;

    /** @var array $posts */
@endphp

@empty($posts)
    <h2 class="text-center text-2xl">
        🤔 There is no posts yet, I'm thinking what to write next
    </h2>
@else
    <div class="divide-y divide-border">
        @foreach($posts as $post)
            <article>
                <div class="flex flex-col md:flex-row gap-7 justify-between items-center">
                    <div class="relative">
                        <x-image-label>In progress</x-image-label>

                        <img
                            data-src="{{ $post['image_sm'] }}"
                            alt="Main image for the post '{{ $post['title'] }}'"
                            class="rounded-lg shadow-lg w-full min-w-[350px] max-w-[400px]"
                            width="331"
                            height="180"
                        >
                    </div>

                    <div class="flex flex-col gap-y-2">
                        <div class="flex flex-col gap-y-2">
                            <h2 class="text-lg lg:text-2xl font-bold">
                                {{ $post['title'] }}
                            </h2>

                            <p class="text-md lg:text-lg font-post">
                                {{ $post['intro'] }}
                            </p>
                        </div>

                        <x-post.tags :tags="$post['tags']" class="text-sm md:text-md mt-2 !gap-2">
                            @if (auth()->check())
                                <a
                                    href="/admin/posts/{{ $post['id'] }}/edit"
                                    class="px-3 leading-[1.5] py-0.5 tracking-wider border border-font-second border-dashed rounded-full transition-opacity hover:opacity-80 uppercase text-xs"
                                >
                                    Edit
                                </a>
                            @endif
                        </x-post.tags>

                        <div class="opacity-70 flex items-center gap-2">
                            <span>Last update on the post:</span>

                            <time datetime="{{ $post['updated_at'] }}" class="font-bold">
                                {{ TimeAgo::trans($post['updated_at']) }}
                            </time>
                        </div>
                    </div>

                    @if (count($posts) > 1)
                        <div class="hidden xl:flex border-4 border-dotted border-border w-24 aspect-square rounded-full flex items-center justify-center">
                            <span class="text-4xl font-post text-font-second">{{ $loop->iteration }}</span>
                        </div>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
@endempty
