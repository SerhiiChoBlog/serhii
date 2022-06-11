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
        class="bg-gray-50"
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

    <div class="container mt-6 pb-6 project">
        <div class="content" v-pre>{!! $project->content !!}</div>
    </div>
@endsection
