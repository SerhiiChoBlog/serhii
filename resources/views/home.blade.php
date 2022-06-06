@extends('layouts.app')

@section('content')
    <section class="bg-[#363636] bg-home-hero flex flex-col justify-between">
        <div class="text-white min-h-[3.25rem]">
            @include('includes.navbar')
        </div>

        <div class="py-[18rem] px-[6rem]">
            <div class="text-center text-white">
                <h1 class="text-3xl">SERHII<span class="text-main">CHO</span></h1>
                <typewriter />
            </div>
        </div>
    </section>

    <div class="home">
        <section class="section is-medium">
            <div class="container">
                <div>
                    <h2 class="home__title mb-6 has-text-centered">Nice to meet you</h2>
                    <p class="home__subtitle">
                        <x-nice-to-meet-you-component />
                        <a href="{{ route('about-me') }}">Read mode about me...</a>
                    </p>
                </div>
            </div>
        </section>

        <section class="section is-medium">
            <div class="container">
                <x-last-posts-component />
            </div>
        </section>
    </div>
@endsection
