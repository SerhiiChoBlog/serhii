@php
    use App\Models\Series;

    /**
     * @var Series $series
     */
@endphp

<article
    class="grid grid-cols-1 lg:grid-cols-[3fr_1fr] rounded-xl shadow-md"
    style="background: linear-gradient(90deg, {{ $series->color_from }} 0%, {{ $series->color_to }} 100%)"
>
    <div class="p-4 lg:p-8 lg:pr-0">
        <img
            src="{{ asset($series->image_xs) }}"
            data-src="{{ asset($series->image_sm) }}"
            alt="{{ $series->title }}"
            class="w-full rounded-lg shadow-md"
            width="750"
            height="250"
        >

        <div class="mt-4">
            <h2 class="text-2xl lg:text-3xl font-bold text-gray-100">
                {{ $series->title }}
            </h2>

            <h3 class="text-lg lg:text-xl text-main-light">
                {{ $series->intro }}
            </h3>

            <h4 class="text-md lg:text-lg text-gray-400">Contains {{ $series->posts_count }} {{ str('article')->plural($series->posts_count) }}</h4>

            <p class="text-md lg:text-lg text-gray-300 mt-3">
                {!! nl2br($series->description) !!}
            </p>
        </div>
    </div>

    <div class="border-t-4 lg:border-l-4 lg:border-t-0 border-dashed border-page p-4 lg:p-8 pl-4 ml-4 lg:pl-4">
        <ul class="grid grid-cols-3 lg:grid-cols-1 gap-2">
            @foreach($series->posts as $post)
                <li>
                    <a
                        href="{{ route('posts.show', $post->slug) }}"
                        class="block"
                    >
                        <img
                            src="{{ asset($post->image_xs) }}"
                            data-src="{{ asset($post->image_sm) }}"
                            class="rounded-lg shadow-md shadow-md w-full"
                            width="550"
                            height="275"
                            alt="Main image for the post '{{ $post->title }}'"
                        />
                    </a>
                </li>

                @for($part = $post->pivot->part + 1; $part <= $series->posts_count; $part++)
                    <li>
                        <div class="w-full relative">
                            <img
                                src="{{ asset('storage/posts/placeholder-xs.jpg') }}"
                                class="opacity-0"
                                width="550"
                                height="275"
                                alt="Placeholder image"
                                aria-hidden="true"
                            />

                            <div
                                class="absolute inset-0 flex items-center justify-center bg-zinc-600 rounded-lg"
                                style="background-color: {{ $series->color_from }}"
                            >
                                <div class="text-center text-gray-300">
                                    <h2 class="text-xl">Part {{ $part }}</h2>
                                    <h3 class="text-lg">In progress...</h3>
                                </div>
                            </div>
                        </div>
                    </li>
                @endfor
            @endforeach
        </ul>
    </div>
</article>
