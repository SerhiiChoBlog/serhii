@extends('layouts.app')

@section('content')
    <section class="hero home-hero is-large is-dark smooth-loader" data-src="/storage/heros/home-hero.jpg">
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
                <x-about-me-component />
            </div>
        </section>


        <section class="section is-medium bg-dark">
            <div class="container">
                <x-home-tech-section :techs="config('technologies.languages')" header="Languages" />
            </div>
        </section>

        <section class="section is-medium">
            <div class="container">
                <x-home-tech-section :techs="config('technologies.frameworks')" header="Frameworks" />
            </div>
        </section>
    </div>
@endsection
