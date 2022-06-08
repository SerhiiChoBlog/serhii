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

    <div class="container mt-6">
        <div class="row">
            @foreach ($projects as $project)
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <a href="/projects/{{ $project['name'] }}">
                        <div class="card project-card">
                            <img class="language-image"
                                src="{{ asset('/storage/languages/' . strtolower($project['language']) . '.png') }}"
                                alt="{{ $project['title'] }}"
                            />

                            <div class="card-content">
                                <div class="content">
                                    <h4 class="card-title">{{ $project['title'] }}</h4>
                                    <p>{{ $project['description'] }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
