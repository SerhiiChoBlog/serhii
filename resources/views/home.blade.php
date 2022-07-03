@extends('layouts.app')

@section('content')
    <x-hero class="bg-white shadow-md" navbar="bg-gray-700 text-white">
        <div class="container mt-4">
            <div class="grid grid-cols-1 lg:grid-cols-[3fr_1fr] gap-5 pt-1">
                <x-home.banner />
                <x-home.last-post />
            </div>
        </div>

        {{-- Welcome --}}
        <section class="py-10">
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
    </x-hero>

    <section class="py-12 bg-page-second relative">
        <div class="w-[50px] aspect-square bg-page absolute top-[-30px] left-1/2 -translate-x-1/2 rotate-45"></div>
        <div class="w-[50px] aspect-square bg-page-second absolute top-[-40px] left-1/2 -translate-x-1/2 rotate-45"></div>
        <div class="w-[20px] aspect-square bg-page absolute top-[-24px] left-1/2 -translate-x-1/2 rotate-45"></div>

        <div class="container">
            <x-home.random-posts-section />
        </div>
    </section>
@endsection
