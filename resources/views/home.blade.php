@php
    /** @var App\Models\Post $post */
@endphp

@extends('layouts.app')

@section('content')
    <x-hero class="bg-white shadow-md" navbar="bg-gray-700 text-white">
        <div class="container mt-4">
            <div class="grid grid-cols-[3fr_1fr] gap-5 pt-1">
                <div class="rounded-lg bg-gray-900 p-10 bg-home-hero-sm lg:bg-home-hero bg-no-repeat bg-top bg-cover relative overflow-hidden h-full shadow-lg">
                    <div class="absolute left-0 right-0 top-0 bottom-0 bg-gradient-to-r from-gray-800 to-gray-800/30"></div>

                    <div class="z-10 absolute top-1/2 -translate-y-1/2 ml-10">
                        <h1 class="text-xl lg:text-4xl relative">
                            <span class="text-gray-300 drop-shadow-md">SERHII</span>
                            <span class="text-main drop-shadow-md">CHO</span>
                        </h1>

                        <typewriter />
                    </div>
                </div>

                <div>
                    <div
                        class="flex flex-col gap-4 justify-between"
                    >
                        <img
                            src="{{ $post->image_sm }}"
                            alt="{{ $post->title }}"
                            class="rounded-lg shadow-lg w-full"
                            width="395"
                            height="215"
                        >

                        <h2 class="text-2xl font-bold px-2">
                            {{ $post->title }}
                        </h2>

                        <p class="text-lg px-2">
                            {{ $post->intro }}
                        </p>

                        <a
                            href="{{ route('posts.show', $post) }}"
                            class="border border-border rounded-lg py-2 px-4 uppercase text-center"
                        >
                            Read latest post
                        </a>
                    </div>
                </div>
            </div> <!-- grid -->
        </div>

        {{-- Welcome --}}
        <section class="py-10">
            <div class="container">
                <div class="px-10 mx-auto">
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

    <section class="py-12 bg-page-second">
        <div class="container">
            <x-home.last-posts-section />
        </div>
    </section>
@endsection
