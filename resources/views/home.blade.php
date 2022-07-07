@extends('layouts.app')

@section('content')
    <x-hero class="relative shadow-md bg-gray-900 bg-home-hero-sm lg:bg-home-hero bg-no-repeat bg-top bg-cover" navbar="text-white">
        <div class="overflow-hidden h-full shadow-lg min-h-[300px] md:min-h-[500px]">
            <div class="absolute left-0 right-0 top-0 bottom-0 bg-gradient-to-r from-gray-800 to-gray-800/30"></div>

            <div class="z-10 absolute top-1/2 -translate-y-1/2 -translate-x-1/2 left-1/2 text-center">
                <h1 class="text-xl lg:text-4xl relative">
                    <span class="text-gray-300 drop-shadow-md">SERHII</span>
                    <span class="text-main drop-shadow-md">CHO</span>
                </h1>

                <h2 class="text-white text-2xl">
                    Professional Full Stack developer
                </h2>

                <div class="flex items-center justify-center mt-5">
                    <form class="flex shadow-lg rounded-md overflow-hidden focus-within:ring-2 focus-within:ring-main">
                        <input
                            type="text"
                            class="px-6 py-4 text-xl w-[500px]"
                            placeholder="Enter post title, project or anything else"
                        />

                        <button class="flex items-center justify-center px-4 bg-white">
                            <svg
                                class="w-6 h-6 text-gray-600 stroke-gray-400"
                                fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                            >
                                <path d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </x-hero>

    {{-- Welcome --}}
    <section class="py-14 md:py-20">
        <div class="container">
            <div class="lg:px-10 mx-auto">
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
        </div>
    </section>

    <section class="py-12 bg-page-second relative">
        <x-section-detail />

        <div class="container">
            <x-home.random-posts-section />
        </div>
    </section>
@endsection
