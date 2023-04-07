@php
    use App\Models\Post;

    /**
     * @var array<int, Post> $latest
     * @var array<int, Post> $monthly_top
     * @var array<int, Post> $posts
     * @var array<int, array<int ,mixed>> $latest_videos
     */

    $last_month = now()->subMonth()->format('F Y');
@endphp

@extends('layouts.main')

@section('content')
    <x-hero
        class="relative bg-home-hero-sm lg:bg-home-hero bg-blend-overlay bg-cover md:bg-fixed bg-center bg-no-repeat shadow-lg"
        navbar="text-white"
    >
        <div>
            <div
                class="absolute left-0 right-0 top-0 bottom-0 bg-gradient-to-r from-gray-900/80 via-gray-900/80 to-gray-900/50"
            ></div>

            <div class="relative z-10 text-center pt-20 pb-32">
                <h1 class="text-2xl lg:text-4xl" aria-label="Serhii Cho">
                    <span class="text-white drop-shadow-md uppercase">{{ config('app.name') }}</span>
                </h1>

                <h2 class="text-white text-md lg:text-2xl mt-2 mx-4 leading-5 md:tracking-wide drop-shadow-md mb-3">
                    Blog about web development and coding
                </h2>

                <search>
                    <div class="min-h-[44px] lg:min-h-[60px]"></div>
                </search>

                <x-home.read-blog-button/>
            </div>
        </div>
    </x-hero>

    <x-home.section
        title="The latest articles"
        intro="The most recent articles"
        :isDark="false"
    >
        <div class="space-y-6">
            @foreach ($latest as $post)
                <x-posts.horizontal-post :post="$post"/>
            @endforeach
        </div>
    </x-home.section>


    <x-home.section
        title="Best of the month"
        :intro="'The most viewed articles in ' . $last_month"
        :isDark="true"
    >
        <div class="space-y-6">
            @foreach ($monthly_top as $post)
                <x-posts.horizontal-post :post="$post"/>
            @endforeach
        </div>
    </x-home.section>

    <x-home.section
        title="You might like"
        intro="Articles which I think you might want to read"
        :isDark="false"
    >
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-0 md:gap-5">
            @foreach ($posts as $post)
                <x-posts.vertical-post :post="$post"/>
            @endforeach
        </div>
    </x-home.section>

    <x-home.section
        title="The latest videos"
        intro="The latest YouTube videos"
        :isDark="true"
    >
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            @foreach ($latest_videos as $video)
                <a
                    href="{{ $video['url'] }}"
                    target="_blank"
                    class="relative transition-opacity hover:opacity-90"
                    rel="noreferrer"
                >
                    <div class="relative">
                        <img
                            src="{{ asset('/storage/icons/youtube.webp') }}"
                            alt="YouTube logo"
                            class="z-10 opacity-90 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[60px]"
                            width="100"
                            height="100"
                        />

                        <img
                            data-src="{{ $video['image'] }}"
                            alt="{{ $video['title'] }}"
                            width="320"
                            height="180"
                            class="rounded-lg shadow-md w-full"
                        >
                    </div>

                    <h2 class="text-xl mt-2 mx-1 leading-7">
                        {{ $video['title'] }}
                    </h2>
                </a>
            @endforeach
        </div>
    </x-home.section>

    <x-home.section
        title="Coming soon"
        intro="The articles which I'm currently working on"
        :isDark="false"
    >
        <x-home.coming-soon-section/>
    </x-home.section>
@endsection
