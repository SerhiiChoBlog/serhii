@extends('layouts.app')

@section('content')
    <section class="hero home-hero is-large is-dark">
        <div class="hero-head">
            @include('includes.navbar')
        </div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title main-logo">SERHII<span class="has-text-info">CHO</span></p>
                <typewriter />
            </div>
        </div>
    </section>

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
@endsection
