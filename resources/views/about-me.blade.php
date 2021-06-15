@extends('layouts.app')

@section('content')
    <section class="hero about-me-hero is-dark smooth-loader">
        <div class="hero-head">
            @include('includes.navbar')
        </div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title">About me</h1>
                <h2 class="subtitle">Hi, my name is Serhii, I live in Kharkiv, Ukraine. Thanks for coming to my little, cozy place. Down below, you can find technologies that I'm working with and other information that might help you to know more about me.</h2>
            </div>
        </div>
    </section>

    <div class="about-me">
        <section class="section is-medium">
            <div class="container">
                <div class="content">
                    <p><x-nice-to-meet-you-component /></p>
                    <p>I web development, my priorities are <strong>code readability</strong> and <strong>performance</strong>. In my free time, I'm writing posts for my blog on programming related subjects.</p>
                </div>
            </div>
        </section>

        <section class="section is-medium">
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
