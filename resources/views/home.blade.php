@php
    /**
     * @var array<int, array<int ,mixed>> $random_posts
     * @var array<int, array<int ,mixed>> $latest_posts
     */
@endphp
@extends('layouts.app')

@section('content')
    <x-hero
        class="bg-gradient-to-r from-[#163249] via-[#657ca1] to-[#657ca1] w-full"
        navbar="text-white"
    >
        <div>
            <div class="text-center pt-20 pb-32">
                <h1 class="text-2xl lg:text-4xl" aria-label="Serhii Cho">
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
