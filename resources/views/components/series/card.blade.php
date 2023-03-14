@php
    use App\Models\Series;

    /**
     * @var Series $series
     */
@endphp

<article class="grid grid-cols-1 lg:grid-cols-[3fr_1fr] gap-5">
    <div>
        <img
            src="{{ asset($series->image_xs) }}"
            data-src="{{ asset($series->image_sm) }}"
            alt="{{ $series->title }}"
            class="w-full rounded-lg shadow-md"
            width="750"
            height="250"
        >

        <div class="flex flex-col gap-y-2 mt-2">
            <h2 class="text-xl lg:text-2xl font-bold">
                {{ $series->title }}
            </h2>

            <p class="text-gray-500">
                {!! $series->description !!}
            </p>
        </div>
    </div>

    <div>
        <div class="flex flex-row lg:flex-col gap-y-2">
            <ul>
                @foreach($series->posts as $post)
                    <li>
                        <a
                            href="{{ route('posts.show', $post->slug) }}"
                            class="block relative group"
                        >
                            <img
                                src="{{ asset($post->image_xs) }}"
                                data-src="{{ asset($post->image_sm) }}"
                                class="rounded-lg shadow-md shadow-[rgba(0,0,0,.2)] w-full"
                                width="550"
                                height="275"
                                alt="Main image for the post '{{ $post->title }}'"
                            />

                            <div class="text-white opacity-0 group-hover:opacity-100 absolute flex flex-col inset-0 bg-gray-900/90 rounded-lg p-5 transition-opacity">
                                <h3 class="text-2xl">Part {{ $post->pivot->part }}</h3>
                                <h4 class="text-lg">{{ $post->title }}</h4>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</article>
