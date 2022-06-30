@php
    /** @var App\Models\Project $project */
@endphp

@extends('layouts.app')

@section('head')
    <script src="{{ asset('js/highlight.js') }}" defer></script>
@endsection

@section('title', $project->title)
@section('description', $project->description)

@section('content')
    <x-hero
        :title="$project->title"
        :subtitle="$project->description"
        class="bg-gradient-to-r from-[#0f0f0f] to-[#383838] text-white"
    >
        <a
            href="{{ $project->url }}"
            target="_blank"
            class="bg-gray-100 text-font px-7 py-3 rounded-full inline-flex mt-5 hover:scale-105 transition-transform shadow-md"
            aria-label="{{ $project->title }}"
            title="Link to GitHub repo '{{ $project->title }}'"
        >
            <div>
                <img
                    src="{{ asset('storage/icons/github-dark.png') }}"
                    width="20"
                    height="20"
                    alt="Github logo"
                />
            </div>

            <span class="ml-2">Open on Github</span>
        </a>
    </x-hero>

    <div class="container mt-6 pb-6 px-8 lg:px-0">
        <div class="project-content text-[1.2rem] prose-h1:text-4xl prose-h2:text-3xl prose-a:inline-block prose-a:mr-2 max-w-4xl mx-auto prose-blockquote:text-font" v-pre>
            {!! $project->content !!}
        </div>
    </div>
@endsection
