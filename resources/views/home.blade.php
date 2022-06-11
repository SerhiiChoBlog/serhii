@extends('layouts.app')

@section('content')
    <section class="bg-[#363636] bg-home-hero bg-no-repeat bg-center bg-cover flex flex-col justify-between">
        <div class="text-white min-h-0 lg:min-h-[3.25rem]">
            <x-navbar />
        </div>

        <div class="py-12 px-5 lg:py-[18rem] lg:px-[6rem]">
            <div class="text-center text-white">
                <h1 class="text-xl lg:text-3xl">SERHII<span class="text-main">CHO</span></h1>
                <typewriter />
            </div>
        </div>
    </section>

    <div>
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
    </div>
@endsection
