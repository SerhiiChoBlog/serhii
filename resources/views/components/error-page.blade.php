@php
    /**
     * @var array<string, string> $links
     * @var array<int, array<mixed>> $posts
     * @var array{id: int, slug: string, title: string, intro: string, image_sm: string, created_at: string, read_time: string} $post
     */
@endphp

@push('title', "$code | Serhii Cho")
@push('description', $header)

<div class="bg-gradient-to-t from-[#593468] to-[#423263] text-white min-h-screen">
    <div class="container py-8">
        <div class="flex gap-10 items-center justify-center">
            <h1 class="text-[10rem] font-main font-black leading-[120%]">
                {{ $code }}
            </h1>

            <h2 class="flex flex-col text-2xl font-post">
                <span>{{ $header }}</span>
                <span>How about posts below?</span>

                <div class="mt-3 flex gap-4">
                    @foreach($links as $title => $link)
                        <a
                            href="{{ $link }}"
                            class="border border-amber-400 hover:border-amber-500 shadow-md shadow-transparent duration-500 hover:shadow-amber-300 transition-shadow px-5 py-1.5 rounded-full text-center uppercase font-main text-sm min-w-[130px]"
                        >
                            {{ $title }}
                        </a>
                    @endforeach
                </div>
            </h2>
        </div>

        <div class="flex gap-4 mt-10">
            @foreach($posts as $post)
                <a
                    href="{{ route('posts.show', $post['slug']) }}"
                    class="border border-transparent transition-colors hover:border-white/30 p-4 rounded-lg"
                >
                    <span class="block mb-1 tracking-wide">
                        {{ $post['read_time'] }} minutes read
                    </span>

                    <article class="space-y-4">
                        <img
                            src="{{ asset($post['image_sm']) }}"
                            alt="{{ $post['title'] }}"
                            class="rounded-lg shadow-lg"
                        />

                        <h2 class="text-xl">
                            {{ $post['title'] }}
                        </h2>

                        <p class="text-lg">{{ $post['intro'] }}</p>
                    </article>
                </a>
            @endforeach
        </div>
    </div>
</div>
