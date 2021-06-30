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
                    <div class="columns">
                        <div class="column is-one-quarter has-text-centered">
                            <img src="{{ asset('storage/serhii.jpg') }}" alt="Serhii Cho" class="my-0 my-auto" width="250">
                        </div>
                        <div class="column">
                            <p><x-nice-to-meet-you-component /></p>
                            <p>I've worked with integration services like <b>Megaplan CRM</b>, <b>Exact Online</b>, payment systems like <b>Mollie</b> and <b>WayForPay</b>. I've built apps in <b>Docker</b> containers, SPAs with <b>Vue</b> and websites with <b>WordPress</b> and <b>Laravel</b>. Likewise, I've done tons of different work for companies in <b>business</b> and <b>e-commerce</b> segment.</p>
                        </div>
                    </div>

                    <h2>My way of working</h2>
                    <p>Like every other person, I hate slow web apps and sites. In web development, my priorities are <b>code readability</b> and <b>performance</b>. You can check my post <a href="/posts/5-techniques-that-i-use-for-building-fast-websites">"5 techniques that I use for building fast websites"</a> where I'm talking about it in details.</p>
                    <p>I'm a big <b>believer in tests</b> and I don't like writing code without them. I prefer <b>PHP Unit</b> but I've tried other testing frameworks as well.</p>

                    <h2>Blog</h2>
                    <p>In my free from coding time, I enjoy writing posts for my <a href="/posts" target="_blank" title="Link to a blog">blog</a> on programming related subjects and learn new things. I mostly share what I've learned along the way and things that can help other developers strengthen their skills.</p>
                    <p>I'm <b>not an expert</b>, so I mostly share things that I do successfully or things that I've learned and spend some time on research. I like writing about things that impress me in <b>software development</b> or things that help me in problem solving.</p>
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
