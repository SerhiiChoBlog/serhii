@extends('layouts.app')

@section('content')
    <x-hero class="relative shadow-md bg-gray-900 bg-home-hero-sm lg:bg-home-hero bg-no-repeat bg-top bg-cover" navbar="text-white">
        <div class="overflow-hidden h-full shadow-lg min-h-[280px] md:min-h-[380px]">
            <div class="absolute left-0 right-0 top-0 bottom-0 bg-gradient-to-r from-gray-900 to-gray-900/50"></div>

            <search />
        </div>

        <div class="absolute flex flex-col gap-y-2 items-center bottom-[-45px] left-1/2 -translate-x-1/2">
            <div class="w-[300px] lg:w-[600px] h-1 bg-page-second"></div>
            <div class="w-[250px] lg:w-[450px] h-1 bg-page-second"></div>
            <div class="w-[200px] lg:w-[300px] h-1 bg-page-second"></div>
        </div>
    </x-hero>

    {{-- Welcome --}}
    <section class="py-20">
        <div class="container">
            <x-home.section-title>Nice to meet you</x-home.section-title>

            <div class="text-lg lg:text-xl font-light leading-7 lg:leading-9">
                <x-home.welcome-section />

                <a
                    href="{{ route('about-me') }}"
                    class="text-link transition-colors hover:text-link-hover ml-1"
                >
                    Read more ...
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 bg-page-second relative">
        <x-section-detail />

        <x-home.section-title>Latest post</x-home.section-title>

        <div class="container">
            <x-home.latest-post-section />
        </div>
    </section>

    <section class="py-20">
        <div class="container">
            <x-home.random-posts-section />
        </div>
    </section>
@endsection
