@extends('layouts.app')

@section('content')
    <x-hero class="bg-gradient-to-r from-gray-700 to-gray-800 text-white">
        <div class="grid grid-cols-[2fr_1fr] gap-7">
            <div class="rounded-xl bg-gray-900 p-10 bg-home-hero-sm lg:bg-home-hero bg-no-repeat bg-top bg-cover relative overflow-hidden min-h-[600px] shadow-xl">
                <div class="absolute left-0 right-0 top-0 bottom-0 bg-black/70"></div>

                <div class="z-10 absolute top-1/2 -translate-y-1/2">
                    <h1 class="text-xl lg:text-3xl relative">
                        <span>SERHII</span>
                        <span class="text-main-light">CHO</span>
                    </h1>

                    <typewriter />
                </div>
            </div>
            <div class="rounded-lg bg-white">
                nice
            </div>
        </div>
    </x-hero>


    <section class="py-8 lg:py-14 px-4">
        <div class="container">
            <div>
                <x-home.section-title>Nice to meet you</x-home.section-title>

                <p class="px-0 lg:px-8 text-lg lg:text-xl font-light leading-7 lg:leading-9">
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

    <section class="py-12 bg-page-second">
        <div class="container">
            <x-home.last-posts-section />
        </div>
    </section>
@endsection
