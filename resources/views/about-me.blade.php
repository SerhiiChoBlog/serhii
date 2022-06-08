@extends('layouts.app')

@section('title', 'Information about me')
@section('description', "Hi, my name is Serhii, I live in Kharkiv, Ukraine. Thanks for coming to my little and cozy place. Here, you can find information that might help you to find out more about me")

@section('content')
    <x-hero title="Information about me"
        subtitle="Hi, my name is Serhii, I live in Kharkiv, Ukraine. Thanks for coming to my little and cozy place.<br>Down below, you can find technologies that I'm working with and other information that might help you to know more about me."
        class="bg-gradient-to-r from-[#163249] via-[#657ca1] to-[#657ca1] text-white"
    />

    <div class="about-me">
        <section class="section is-medium">
            <div class="container">
                <div class="content">
                    <div class="columns">
                        <div class="column is-one-quarter has-text-centered">
                            <img src="{{ asset('storage/serhii.jpg') }}"
                                alt="Serhii Cho"
                                class="my-0 my-auto"
                                width="250"
                                style="border-radius: 9px; box-shadow: 2px 2px 7px rgba(0, 0, 0, .3)"
                            />
                        </div>
                        <div class="column">
                            <p><x-home.welcome-section /></p>
                            <p>I've worked with integration services like <b>Megaplan CRM</b>, <b>Exact Online</b>, payment systems like <b>Mollie</b>, <b>Bitpay</b> and <b>WayForPay</b>. I've built apps in <b>Docker</b> containers, SPAs with <b>Vue</b>, and websites with <b>WordPress</b> and <b>Laravel</b>. Likewise, I've done tons of different work for companies in <b>business</b> and <b>e-commerce</b> segment. Building programs and interfaces for generating different types of documents, programs for stuff management and communication with clients.</p>
                        </div>
                    </div>

                    <h2>My way of working</h2>
                    <p>Like every other person, I hate slow web apps and sites. In web development, my priorities are <b>code readability</b> and <b>performance</b>. You can check my post <a href="/posts/5-techniques-that-i-use-for-building-fast-websites">"5 techniques that I use for building fast websites"</a> where I'm talking about it in details.</p>
                    <p>I'm a big believer in tests, and long-term maintainability of the software. If you are going to contact me, include 🤓 emoji at the beginning of your message. That way, I'll know that you are actually interested working with me.</p>

                    <h2>Blog</h2>
                    <p>In my free from coding time, I enjoy writing posts for my <a href="/posts" target="_blank" title="Link to a blog">blog</a> on programming related subjects and learn new things. I mostly share what I've learned along the way and things that can help other developers strengthen their skills.</p>
                    <p>I'm <b>not an expert</b>, so I mostly share things that I do successfully or things that I've learned and spend some time on research. I like writing about things that impress me in <b>software development</b> or things that help me in problem solving.</p>

                    <h2>I will not work in</h2>
                    <ul>
                        <li>
                            <strong>Companies that have an opinion that testing your code is just a waste of time.</strong>
                            <p>I understand that sometimes you need to create some quick prototype as fast as you can just to get it out there. I would not write tests for those prototypes.</p>
                        </li>
                        <li>
                            <strong>Low salary companies.</strong>
                            <p>Great developers have a considerable salary. You can't hire a professional and expect low salary for that person. </p>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="section is-medium">
            <div class="container">
                <x-about.tech-section :techs="config('technologies.languages')" header="Languages" />
            </div>
        </section>

        <section class="section is-medium">
            <div class="container">
                <x-about.tech-section :techs="config('technologies.frameworks')" header="Frameworks / CMS" />
            </div>
        </section>

        <section class="section is-medium">
            <div class="container">
                <x-about.tech-section :techs="config('technologies.technologies')" header="Other technologies" />
            </div>
        </section>

        <section class="section is-medium">
            <div class="container">
                <x-about.tech-section :techs="config('technologies.skills')" header="Personal skills" />
            </div>
        </section>

        <section class="section is-medium">
            <div class="container">
                <x-about.sites-section />
            </div>
        </section>
    </div>
@endsection
