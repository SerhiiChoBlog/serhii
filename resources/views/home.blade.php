@extends('layouts.app')

@section('content')
    <x-hero
        class="relative bg-home-hero-sm lg:bg-home-hero w-full h-screen bg-blend-overlay bg-cover md:bg-fixed bg-top bg-no-repeat"
        navbar="text-white"
    >
        <div class="overflow-hidden h-full min-h-[280px] md:min-h-[380px]">
            <div class="absolute left-0 right-0 top-0 bottom-0 bg-gradient-to-r from-gray-900 via-gray-900/80 to-gray-900/50"></div>
            <search />
        </div>

        <div class="absolute flex flex-col gap-y-2 items-center -bottom-4 left-1/2 -translate-x-1/2 z-[1]">
            <div class="w-[300px] lg:w-[600px] h-1 bg-page-second"></div>
            <div class="w-[250px] lg:w-[450px] h-1 bg-page-second"></div>
            <div class="w-[200px] lg:w-[300px] h-1 bg-page-second"></div>
        </div>
    </x-hero>

    <x-home.section
        title="Nice to meet you"
        class="-translate-y-8 bg-page rounded-xl container"
    >
        <div class="text-lg lg:text-xl font-light leading-7 lg:leading-9">
            <x-home.welcome-section />

            <a
                href="{{ route('about-me') }}"
                class="text-link transition-colors hover:text-link-hover ml-1"
            >
                Read more ...
            </a>
        </div>
    </x-home.section>

    <x-home.section title="Latest post" isDark="true">
        <x-home.latest-post-section />
    </x-home.section>

    <x-home.section title="More random posts">
        <x-home.random-posts-section />
    </x-home.section>
@endsection
