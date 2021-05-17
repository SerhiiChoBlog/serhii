@php
    /** @var App\Models\Project $project */
@endphp

@extends('layouts.app')

@section('head')
    <script src="{{ asset('js/highlight.js') }}"></script>
@endsection

@section('content')
    <section class="project-hero is-light">
        <div class="hero-head">@include('includes.navbar', ['is_grey' => true])</div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">{{ $project->title }}</p>
                <p class="subtitle has-text-left">{{ $project->description }}</p>
                <a href="{{ $project->url }}" target="_blank" class="button is-rounded is-dark">
                    <img src="{{ asset('storage/icons/github.png') }}" width="20" alt="Github logo" />
                    <span class="ml-2">Open on Github</span>
                </a>
            </div>
        </div>
    </section>

    <div class="container mt-6 pb-6 project">
        <div class="content" v-pre>{!! $project->content !!}</div>
    </div>
@endsection

@section('script')
    <script>
        const blocks = document.querySelectorAll('pre code')
        blocks.forEach(function (block) {
            hljs.highlightElement(block)
        })
    </script>
@endsection
