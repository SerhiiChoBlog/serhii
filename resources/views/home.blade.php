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

    <div>
        <section class="p-8">
            <div class="container">
                <div>
                    <x-home.section-title>Nice to meet you</x-home.section-title>
                    <p class="text-xl font-weight-light leading-8">
                        <x-home.welcome-section />
                        <a href="{{ route('about-me') }}" class="text-main hover:underline">Read mode about me...</a>
                    </p>
                </div>
            </div>
        </section>

        <section class="p-8 bg-gray-100">
            <div class="container">
                <x-home.last-posts-section />
            </div>
        </section>
    </div>
@endsection
