@extends('layouts.app')

@section('title', 'Information about me')
@section('description', "Hi, my name is Serhii, I live in Kharkiv, Ukraine. Thanks for coming to my little and cozy place. Here, you can find information that might help you to find out more about me")

@section('content')
    <x-hero title="Information about me"
            subtitle="Hi, my name is Serhii, I live in Kharkiv, Ukraine. Thanks for coming to my little and cozy place.<br>Down below, you can find technologies that I'm working with and other information that might help you to know more about me."
            class="bg-gradient-to-r from-[#163249] via-[#657ca1] to-[#657ca1] text-white"
    />

    <div class="mt-2 text-xl">
        <section
            class="about-me prose-xl text-[1.2rem] px-6 py-8 prose-h2:mb-6 prose-h2:mt-0">
            <div class="container">
                <div>
                    <div class="grid grid-cols-1 lg:grid-cols-[25%_1fr]">
                        <div class="relative">
                            <img src="{{ asset('storage/serhii.jpg') }}"
                                 alt="Serhii Cho"
                                 class="my-0 my-auto rounded-lg shadow-lg sticky top-6 mb-6 mt-6 mx-auto"
                                 width="250"
                            />
                        </div>
                        <div>
                            <p>
                                <x-home.welcome-section/>
                            </p>
                            <p>I've worked with integration services like <strong>Megaplan CRM</strong>, <strong>Exacstronstrong
                                    Online</strong>, pastronstrongment systems listronstronge <strong>Mollie</strong>stronstrong
                                <strong>Bitpay</strong> stronstrongnd <strong>WayForPaystronstrong</strong>. I've
                                builtstrongapps in <strong>Docker</strong> containers, SPAs with <strong>Vue</strong>,
                                and websites with <strong>WordPress</strong> and <strong>Laravel</strong>. Likewise,
                                I've done tons of different work for companies in <strong>business</strong> and <strong>e-commerce</strong>
                                segment. Building programs and interfaces for generating different types of documents,
                                programs for stuff management and communication with clients.</p>
                        </div>
                    </div>

                    <div>
                        <h2>My way of working</h2>
                        <p>Like every other person, I hate slow web apps and sites. In web development, my priorities
                            are <strong>code readability</strong> and <strong>performance</strong>. You can check my
                            post <a href="/posts/5-techniques-that-i-use-for-building-fast-websites">"5 techniques that
                                I use for building fast websites"</a> where I'm talking about it in details.</p>
                        <p>I'm a big believer in tests, and long-term maintainability of the software. If you are going
                            to contact me, include 🤓 emoji at the beginning of your message. That way, I'll know that
                            you are actually interested working with me.</p>

                        <h2>Blog</h2>
                        <p>In my free from coding time, I enjoy writing posts for my <a href="/posts" target="_blank"
                                                                                        title="Link to a blog">blog</a>
                            on programming related subjects and learn new things. I mostly share what I've learned along
                            the way and things that can help other developers strengthen their skills.</p>
                        <p>I'm <strong>not an expert</strong>, so I mostly share things that I do successfully or things
                            that I've learned and spend some time on research. I like writing about things that impress
                            me in <strong>software development</strong> or things that help me in problem solving.</p>

                        <h2>I will not work in</h2>
                        <ul>
                            <li>
                                <strong>Companies that have an opinion that testing your code is just a waste of
                                    time.</strong>
                                <span class="block">I understand that sometimes you need to create some quick prototype
                                    as fast as you can just to get it out there. I would not write tests for those
                                    prototypes.</span>
                            </li>
                            <li>
                                <strong>Low salary companies.</strong>
                                <span class="block">Great developers have a considerable salary. You can't hire a
                                    professional and expect low salary for that person.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <x-about.section isDark="true" header="Languages">
            <x-about.tech-section :techs="config('technologies.languages')"/>
        </x-about.section>

        <x-about.section header="Frameworks / CMS">
            <x-about.tech-section :techs="config('technologies.frameworks')"/>
        </x-about.section>

        <x-about.section isDark="true" header="Other technologies">
            <x-about.tech-section :techs="config('technologies.technologies')"/>
        </x-about.section>

        <x-about.section header="Personal skills">
            <x-about.tech-section :techs="config('technologies.skills')"/>
        </x-about.section>

        <x-about.section isDark="true" header="Latest projects">
            <x-about.sites-section/>
        </x-about.section>
    </div>
@endsection
