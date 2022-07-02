@extends('layouts.app')

@section('content')
    <x-hero class="bg-gradient-to-r from-gray-800 via-gray-700 to-gray-800 text-white shadow-md p-5">
        <div class="grid grid-cols-[2fr_1fr] gap-5 pt-4">
            <div class="rounded-xl bg-gray-900 p-10 bg-home-hero-sm lg:bg-home-hero bg-no-repeat bg-top bg-cover relative overflow-hidden min-h-[400px]">
                <div class="absolute left-0 right-0 top-0 bottom-0 bg-gradient-to-r from-gray-800 to-gray-800/30"></div>

                <div class="z-10 absolute top-1/2 -translate-y-1/2">
                    <h1 class="text-xl lg:text-4xl relative">
                        <span class="text-gray-300">SERHII</span>
                        <span class="text-main-light">CHO</span>
                    </h1>

                    <typewriter />
                </div>
            </div>

            <div class="grid grid-rows-4 gap-5">
                @foreach ($pages as $page)
                    <a
                        href="{{ $page['href'] }}"
                        class="flex items-center text-white pl-10 rounded-xl bg-gray-800 transition-transform hover:translate-x-2 duration-500"
                    >
                        <h4 class="text-3xl drop-shadow-md text-gray-300 uppercase">
                            {{ $page['title'] }}
                        </h4>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="container px-0">
            <section class="h-[400px] bg-gray-800 mt-5 rounded-[50%] text-gray-300 flex flex-col justify-center">
                <div class="text-center w-3/4 mx-auto">
                    <h2 class="text-2xl lg:text-3xl pb-5 uppercase">Nice to meet you</h2>

                    <p class="text-lg lg:text-xl font-light leading-7 lg:leading-9">
                        <x-home.welcome-section />

                        <a
                            href="{{ route('about-me') }}"
                            class="text-main-light hover:underline transition-colors block"
                        >
                            Read mode about me...
                        </a>
                    </p>
                </div>
            </section>
        </div>
    </x-hero>

    <section class="py-12 bg-page-second">
        <div class="container">
            <x-home.last-posts-section />
        </div>
    </section>
@endsection
