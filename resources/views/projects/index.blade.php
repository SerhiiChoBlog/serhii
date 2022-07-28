@php
    /** @var array[] $projects */
@endphp

@extends('layouts.app')

@section('title', 'Open-source projects')
@section('description', "I'm a the maintainer of se")

@section('content')
    <x-hero
        title="Open-source projects"
        subtitle="I'm the maintainer of several open-source libraries and browser extension.<br>You can contribute to any of them on GitHub, and I would gladly look into your pull request or issue."
        class="bg-gradient-to-r from-[#51895c] via-[#4c5f7d] to-[#51895c] text-white"
    />

    <div class="container my-6">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 -translate-y-12 bg-page rounded-xl px-5 pt-5">

            @foreach ($projects as $project)
                <article>
                    <a
                        href="/projects/{{ $project['name'] }}"
                        class="bg-page-second p-7 h-full rounded-md shadow-md hover:shadow-lg transition-shadow relative flex flex-col justify-center min-h-[300px]"
                        title="Go to a project"
                    >
                        <div>
                            <img
                                src="{{ asset('/storage/languages/' . strtolower($project['language']) . '.webp') }}"
                                alt="{{ $project['title'] }}"
                                class="absolute right-4 top-4"
                                width="50"
                                height="50"
                            />

                            <div>
                                <h2 class="first-letter:text-main font-bold text-2xl text-font uppercase">
                                    {{ $project['title'] }}
                                </h2>

                                <p class="text-lg mt-3 text-font-second border-t border-t-border pt-3">
                                    {{ $project['description'] }}
                                </p>

                                <div class="absolute bottom-3 right-5 text-md flex items-center text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    <span>{{ $project['stars'] }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
            @endforeach

        </div>
    </div>
@endsection
