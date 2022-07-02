@extends('layouts.app')

@section('content')
    <x-hero class="bg-gradient-to-r from-gray-600 to-gray-800 text-white shadow-md p-7">
        <div class="grid grid-cols-[2fr_1fr] gap-7 pt-4">
            <div class="rounded-xl bg-gray-900 p-10 bg-home-hero-sm lg:bg-home-hero bg-no-repeat bg-top bg-cover relative overflow-hidden min-h-[600px] shadow-md">
                <div class="absolute left-0 right-0 top-0 bottom-0 bg-black/60"></div>

                <div class="z-10 absolute top-1/2 -translate-y-1/2">
                    <h1 class="text-xl lg:text-3xl relative">
                        <span>SERHII</span>
                        <span class="text-main-light">CHO</span>
                    </h1>

                    <typewriter />
                </div>
            </div>

            <div class="grid grid-rows-4 gap-7">
                <div class="bg-white rounded-lg"></div>
                <div class="bg-white rounded-lg"></div>
                <div class="bg-white rounded-lg"></div>
                <div class="bg-white rounded-lg"></div>
            </div>
        </div>

        <section class="p-8 lg:p-10 bg-white text-font mt-7 rounded-lg">
            <div class="container px-0">
                <div>
                    <h2 class="text-2xl lg:text-4xl pb-5 lg:pb-10">Nice to meet you</h2>

                    <p class="text-lg lg:text-xl font-light leading-7 lg:leading-9">
                        <x-home.welcome-section />

                        <a
                            href="{{ route('about-me') }}"
                            class="text-link hover:text-link-hover hover:underline transition-colors"
                        >
                            Read mode about me...
                        </a>
                    </p>
                </div>
            </div>
        </section>
    </x-hero>

    <section class="py-12 bg-page-second">
        <div class="container">
            <x-home.last-posts-section />
        </div>
    </section>
@endsection
