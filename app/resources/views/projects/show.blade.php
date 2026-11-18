@php
    /** @var App\Models\Project $project */
@endphp

@extends('layouts.main')

@push('head')
    <script src="{{ asset('js/highlight.js') }}" defer></script>
@endpush

@push('title', $project->title)
@push('description', str($project->description)->limit(147))

@section('content')
    <x-hero
        :mainTitle="$project->title"
        :subtitle="$project->description"
        class="bg-linear-to-r from-[#0f0f0f] to-[#383838] text-white"
    >
        <div class="text-center">
            <a
                href="{{ $project->url }}"
                target="_blank"
                class="bg-gradient bg-linear-to-br from-gray-200 via-white to-gray-200 text-black px-7 py-3 rounded-full inline-flex mt-5 hover:scale-105 transition-transform shadow-md mx-auto items-center"
                aria-label="{{ $project->title }}"
                title="Link to GitHub repo '{{ $project->title }}'"
            >
                <div>
                    <img
                        src="{{ asset('img/icons/github.webp') }}"
                        width="20"
                        height="20"
                        alt="GitHub logo"
                    />
                </div>

                <span class="ml-2">Open on GitHub</span>
            </a>
        </div>
    </x-hero>

    <div class="container">
        <div class="bg-page max-w-[900px] mx-auto -translate-y-6 rounded-xl px-3 pt-3">
            <div class="project-content text-[1.2rem] prose-h1:text-4xl prose-h2:text-3xl prose-a:inline-block prose-a:mr-2 max-w-4xl mx-auto prose-blockquote:text-font" v-pre>
                {!! $project->content !!}
            </div>
        </div>
    </div>
@endsection
