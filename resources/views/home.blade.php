@extends('layouts.app')

@section('content')
    <section class="bg-home-hero-sm lg:bg-home-hero bg-no-repeat bg-center bg-cover flex flex-col justify-between relative">
        <div class="absolute left-0 right-0 top-0 bottom-0 bg-black/70"></div>

        <div class="text-white min-h-0 lg:min-h-[3.25rem]">
            <x-navbar />
        </div>

        <div class="py-12 px-5 lg:py-[18rem] lg:px-[6rem] relative">
            <div class="text-center text-white">
                <h1 class="text-xl font-arizona lg:text-3xl">SERHII<span class="text-main">CHO</span></h1>
                <typewriter />
            </div>
        </div>
    </section>

    <section class="py-8 lg:py-14 px-4">
        <div class="container">
            <div>
                <x-home.section-title>Nice to meet you</x-home.section-title>

                <p class="text-lg lg:text-xl font-light leading-7 lg:leading-9">
                    <x-home.welcome-section />

                    <a href="{{ route('about-me') }}"
                        class="text-link hover:text-link-hover hover:underline transition-colors"
                    >Read mode about me...</a>
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
