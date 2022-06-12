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
    <x-hero :title="$project->title"
        :subtitle="$project->description"
        class="bg-gray-100 dark:bg-gray-800 dark:text-white"
    >
        <a href="{{ $project->url }}"
           target="_blank"
           class="bg-gray-700 text-white px-7 py-3 rounded-full inline-flex mt-5 hover:bg-gray-800 transition-colors shadow-md"
        >
            <div>
                <img src="{{ asset('storage/icons/github.png') }}" width="20" alt="Github logo" />
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
