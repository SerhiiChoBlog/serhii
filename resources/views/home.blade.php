@php
    /** @var App\Models\Post $post */
@endphp

@extends('layouts.app')

@section('content')
    <x-hero class="bg-white shadow-md px-5">
        <div class="container">
            <div class="grid grid-cols-[3fr_1fr] gap-5 pt-1">
                <div class="rounded-xl bg-gray-900 p-10 bg-home-hero-sm lg:bg-home-hero bg-no-repeat bg-top bg-cover relative overflow-hidden h-[500px] shadow-lg">
                    <div class="absolute left-0 right-0 top-0 bottom-0 bg-gradient-to-r from-gray-800 to-gray-800/30"></div>

                    <div class="z-10 absolute top-1/2 -translate-y-1/2 ml-10">
                        <h1 class="text-xl lg:text-4xl relative">
                            <span class="text-gray-300">SERHII</span>
                            <span class="text-main-light">CHO</span>
                        </h1>

                        <typewriter />
                    </div>
                </div>

                <div class="flex items-center">
                    <div>
                        <div class="border mb-3 py-1 px-5 uppercase flex justify-between text-gray-700 border-gray-400 rounded-lg font-bold text-xl shadow-md">
                            <b>L</b><b>a</b><b>t</b><b>e</b><b>s</b><b>t</b>
                            <b class="ml-5">p</b><b>o</b><b>s</b><b>t</b>
                        </div>

                        <a
                            href="{{ route('posts.show', $post) }}"
                            class="flex flex-col gap-4 justify-between"
                        >
                            <img
                                src="{{ $post->image_sm }}"
                                alt="{{ $post->title }}"
                                class="rounded-lg shadow-lg w-full"
                                width="395"
                                height="215"
                            >

                            <div class="px-4 space-y-4">
                                <h2 class="text-2xl font-bold">
                                    {{ $post->title }}
                                </h2>

                                <p class="text-lg">
                                    {{ $post->intro }}
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <section class="pt-14 pb-20 flex flex-col justify-center">
            <div class="container">
                <div class="px-10 mx-auto">
                    <div class="flex gap-14 text-lg lg:text-xl font-light leading-7 lg:leading-9">
                        <div>
                            <x-home.welcome-section />
                        </div>

                        <div class="flex items-center">
                            <a
                                href="{{ route('about-me') }}"
                                class="inline-block bg-white text-xl py-4 px-10 text-center rounded-xl uppercase border min-w-[250px]"
                            >
                                Read more
                            </a>
                        </div>
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
