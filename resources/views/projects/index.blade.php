@php
    /** @var array[] $projects */
@endphp

@extends('layouts.app')

@section('title', 'Open-source projects')
@section('description', "I'm a the maintainer of se")

@section('content')
    <x-hero title="Open-source projects"
        subtitle="I'm the maintainer of several open-source libraries and browser extension.<br>You can contribute to any of them on GitHub, and I would gladly look into your pull request or issue."
        class="bg-gradient-to-r from-[#51895c] via-[#4c5f7d] to-[#51895c] text-white"
    />

    <div class="container my-6">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($projects as $project)
                <a href="/projects/{{ $project['name'] }}"
                   class="bg-page-second p-7 rounded-md shadow-md hover:shadow-lg transition-shadow relative flex flex-col justify-center min-h-[300px]"
                >
                    <div>
                        <img src="{{ asset('/storage/languages/' . strtolower($project['language']) . '.png') }}"
                            alt="{{ $project['title'] }}"
                            class="absolute right-4 top-4"
                        />

                        <div>
                            <h4 class="first-letter:text-main-dark first-letter:text-3xl text-2xl text-font">
                                {{ $project['title'] }}
                            </h4>
                            <p class="text-md mt-3 text-font-second border-t border-t-border pt-3">
                                {{ $project['description'] }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
