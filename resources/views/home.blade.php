@extends('layouts.app')

@section('content')
    <x-hero
        class="relative bg-home-hero-sm lg:bg-home-hero w-full h-screen bg-blend-overlay bg-cover md:bg-fixed bg-top bg-no-repeat"
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
                    Let's make the Web a better place
                </h2>

                <search>
                    <div class="min-h-[44px] lg:min-h-[60px]"></div>
                </search>

                <x-home.tag-suggestions />
                <x-home.read-blog-button />
            </div>

            <scroll-down />
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
        title="Blog about web development"
        intro="Let's learn how to write readable, maintainable, and efficient code together"
        class="-translate-y-8 bg-page rounded-xl container"
    >
        <div class="text-lg lg:text-xl font-light leading-7 lg:leading-9 first-letter:text-2xl">
            While PHP continues being the most used server-side language on the Internet, it attracts plenty of new programmers.
            Whether you're a beginner or an experienced developer, I'm sure you'll not be disappointed if you choose to stay.
            Whether you are a full-stack developer or just a back-end developer, <b class="font-sans font-bold">this blog will help you to write readable, maintainable, and high-quality code.</b>
            Moreover, you'll be able to expand your knowledge about different coding practices, methodologies, libraries, and tools.
        </div>
    </x-home.section>

    <x-home.section title="Latest articles" intro="The latest published posts in the blog" isDark="true">
        <x-home.latest-post-section />
    </x-home.section>

    <x-home.section title="More articles" intro="Few random posts that you might be interested in">
        <x-home.random-posts-section />
    </x-home.section>

    <x-home.section title="Coming soon" intro="The articles which I'm currently working on" isDark="true">
        <x-home.coming-soon-section />
    </x-home.section>

    <subscription></subscription>
@endsection
