@extends('layouts.app')

@section('content')
    <section class="hero home-hero is-large is-dark smooth-loader">
        <div class="hero-head">
            @include('includes.navbar')
        </div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <typewriter />
            </div>
        </div>
    </section>

    <div class="home">
        <section class="section is-medium">
            <div class="container">
                <div>
                    <h2 class="home__title mb-6 has-text-centered">Nice to meet you</h2>
                    <p class="home__subtitle">
                        <x-nice-to-meet-you-component />
                    </p>
                </div>
            </div>
        </section>

        <section class="section is-medium">
            <div class="container">
                <x-last-posts-component />
            </div>
        </section>
    </div>
@endsection
