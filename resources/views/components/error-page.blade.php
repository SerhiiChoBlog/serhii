@php
    /**
     * @var array<int, array<mixed>> $posts
     * @var array{id: int, slug: string, title: string, intro: string, image_sm: string, created_at: string, read_time: string} $post
     */
@endphp

@push('title', "$code | Serhii Cho")
@push('description', $header)

<div class="bg-gradient-to-t from-[#593468] to-[#423263] text-white min-h-screen">
    <x-hero class="bg-transparent text-white" />

    <div class="container py-8">
        <h1 class="text-[10rem] text-center font-main font-black leading-[120%]">
            {{ $code }}
        </h1>

        <h2 class="flex flex-col text-2xl font-post text-center">
            <span>{{ $header }}</span>
            <span>How about these posts?</span>
        </h2>

        <div class="flex gap-8 mt-10">
            @foreach($posts as $post)
                <a
                    href="{{ route('posts.show', $post['slug']) }}"
                    class="border border-transparent transition-colors hover:border-white/30 p-4 rounded-lg"
                >
                    <article class="space-y-4 ">
                        <img
                            src="{{ asset($post['image_sm']) }}"
                            alt="{{ $post['title'] }}"
                            class="rounded-lg shadow-lg"
                        />

                        <h2 class="text-xl">{{ $post['title'] }}</h2>

                        <p class="text-lg">{{ $post['intro'] }}</p>
                    </article>
                </a>
            @endforeach
        </div>
    </div>
</div>
