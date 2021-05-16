@extends('layouts.app')

@section('content')

<section class="hero projects-hero is-dark">
    <div class="hero-head">@include('includes.navbar')</div>

    <div class="hero-body">
        <div class="container has-text-centered">
            <p class="title">Open source</p>
            <p class="subtitle">I want to share with you some of my open source package from Github</p>
        </div>
    </div>
</section>

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
