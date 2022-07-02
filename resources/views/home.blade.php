@extends('layouts.app')

@section('content')
    <x-hero class="bg-gradient-to-r from-gray-800 via-gray-700 to-gray-800 text-white shadow-md p-5">
        <div class="grid grid-cols-[2fr_1fr] gap-5 pt-4">
            <div class="rounded-xl bg-gray-900 p-10 bg-home-hero-sm lg:bg-home-hero bg-no-repeat bg-top bg-cover relative overflow-hidden min-h-[400px]">
                <div class="absolute left-0 right-0 top-0 bottom-0 bg-gradient-to-r from-gray-800 to-gray-800/30"></div>

                <div class="z-10 absolute top-1/2 -translate-y-1/2 ml-10">
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
                        class="flex items-center text-white pl-10 rounded-xl bg-gray-800 transition-transform hover:translate-x-2 duration-500 shadow-[-11px_7px_10px_rgba(0,0,0,.1)]"
                    >
                        <h4 class="text-xl drop-shadow-md text-gray-300 uppercase">
                            {{ $page['title'] }}
                        </h4>
                    </a>
                @endforeach
            </div>
        </div>

        <section class="pt-14 pb-20 text-gray-300 flex flex-col justify-center">
            <div class="px-14 mx-auto">
                <div class="flex gap-14 text-lg lg:text-xl font-light leading-7 lg:leading-9">
                    <div>
                        <x-home.welcome-section />
                    </div>

                    <div class="flex items-center">
                        <a
                            href="{{ route('about-me') }}"
                            class="inline-block bg-gray-800 text-xl py-4 px-10 text-center rounded-xl uppercase shadow-xl min-w-[300px]"
                        >
                            Read more
                        </a>
                    </div>
                </p>
            </div>
        </section>
    </x-hero>

    <section class="py-12 bg-page-second">
        <div class="container">
            <x-home.last-posts-section />
        </div>
    </section>
@endsection
