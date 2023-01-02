@php
    /**
     * @var array<int, array<int ,mixed>> $random_posts
     * @var array<int, array<int ,mixed>> $latest_posts
     */
@endphp
@extends('layouts.app')

@section('content')
    <x-hero
        class="relative bg-home-hero-sm lg:bg-home-hero w-full h-[500px] lg:h-[700px] bg-blend-overlay bg-cover md:bg-fixed bg-top bg-no-repeat"
        navbar="text-white"
    >
        <div class="overflow-hidden h-full min-h-[280px] md:min-h-[380px]">
            <div class="absolute left-0 right-0 top-0 bottom-0 bg-gradient-to-r from-gray-900 via-gray-900/80 to-gray-900/50 opacity-50"></div>

            <div class="z-10 absolute top-1/2 -translate-y-1/2 -translate-x-1/2 left-1/2 text-center w-full">
                <h1 class="text-2xl lg:text-4xl relative" aria-label="Serhii Cho">
                    <span class="text-white drop-shadow-md">SERHII</span>
                    <span class="text-main drop-shadow-md">CHO</span>
                </h1>

                <h2 class="text-white text-md lg:text-2xl mt-2 mx-4 leading-5 md:tracking-wide drop-shadow-md">
                    Blog about web development
                </h2>

                <search>
                    <div class="min-h-[44px] lg:min-h-[60px]"></div>
                </search>

                <x-home.tag-suggestions />
                <x-home.read-blog-button />
            </div>
        </div>

        <div
            class="absolute flex flex-col gap-y-2 items-center -bottom-4 left-1/2 -translate-x-1/2 z-[1]"
            id="home-decoration-lines"
        >
            <div class="w-[300px] lg:w-[600px] h-1 bg-page-second"></div>
            <div class="w-[250px] lg:w-[450px] h-1 bg-page-second"></div>
            <div class="w-[200px] lg:w-[300px] h-1 bg-page-second"></div>
        </div>
    </x-hero>

    <x-home.section
        title="Web development Articles"
        intro="Few posts that you might be interested in"
        class="-translate-y-8 bg-page rounded-xl container"
    >
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 overflow-x-hidden">
            @foreach ($random_posts as $post)
                <x-posts.vertical-post :post="$post" />
            @endforeach
        </div>
    </x-home.section>

    <x-home.section
        title="Latest articles"
        intro="The latest published posts in the blog" isDark="true"
    >
        @foreach ($latest_posts as $post)
            <x-posts.horizontal-post :post="$post" />
        @endforeach
    </x-home.section>

    <x-home.section title="Coming soon" intro="The articles which I'm currently working on">
        <x-home.coming-soon-section />
    </x-home.section>

    <subscription></subscription>
@endsection
