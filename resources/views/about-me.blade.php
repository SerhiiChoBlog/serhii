@extends('layouts.app')

@push('title', 'Information about Serhii Cho')
@push('description', "Serhii Cho is a Ukrainian web developer and blogger who is writing about enhancing your knowledge in creating fast and robust web apps")

@section('content')
    <x-hero
        title="Serhii Chornenkyi"
        subtitle="Serhii Cho is a Ukrainian web developer and blogger who is writing about<br />enhancing your knowledge in creating fast and robust web apps"
        class="bg-gradient-to-r from-[#163249] via-[#657ca1] to-[#657ca1] text-white print:bg-none print:text-black"
    >
        <div class="text-center">
            <button
                onclick="window.print();return false;"
                type="button"
                class="mt-7 bg-white rounded-full px-10 py-3 text-font uppercase print:hidden inline-flex gap-3 shadow-md hover:shadow-lg transition-shadow transition-colors hover:text-black"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                </svg>

                Print
            </button>
        </div>
    </x-hero>

    <div class="mt-2 text-xl">
        <section class="about-me prose-xl text-[1.2rem] px-2 lg:px-6 py-8 prose-h2:mb-6 prose-h2:mt-0">
            <div class="container">
                <div class="bg-page -translate-y-16 rounded-xl pt-8">
                    <div class="grid grid-cols-1 gap-x-6 lg:grid-cols-[25%_1fr]">
                        <div class="relative">
                            <div class="w-[250px] h-[250px] mx-auto rounded-lg shadow-lg sticky top-20 mb-6">
                                <avatar />
                            </div>
                        </div>

                        <div>
                            <h2>Experience</h2>

                            <p>
                                <x-home.welcome-section/>
                            </p>

                            <p>
                                I've worked with integration services like <strong>Megaplan CRM</strong>,
                                <strong>Exact Online</strong>, payment systems like <strong>Mollie</strong>,
                                <strong>Bitpay</strong> and <strong>WayForPay</strong>. I've built apps in <strong>Docker</strong>
                                containers, SPAs with <strong>Vue</strong>, <strong>React</strong>, and websites with
                                <strong>WordPress</strong> and <strong>Laravel</strong>. Likewise, I've done tons of
                                different work for companies in <strong>business</strong> and <strong>e-commerce</strong>
                                segment. Building programs and interfaces for generating different types of documents,
                                programs for stuff management, communication with clients, chat bots and tons of web API.
                            </p>

{{--                            <h2>Looking for job</h2>--}}

{{--                            <p>--}}
{{--                                I'm looking forward to work in company from 🇪🇺 🇺🇸 🇨🇦 🇦🇺 🏴󠁧󠁢󠁥󠁮󠁧󠁿 by a contract.--}}
{{--                                I'll be comfortable to work remotely <strong>120 hours per month</strong> in non--}}
{{--                                outsource company. I'm also ready to relocate from Ukraine and work in the office in countries--}}
{{--                                listed above.--}}
{{--                            </p>--}}

{{--                            <p>--}}
{{--                                I can work on a backend as a Laravel developer, as I have lots of experience with <strong>Laravel</strong>--}}
{{--                                and <strong>PHP</strong>. Or, I can also work on the frontend with <strong>Vue.js</strong> or--}}
{{--                                <strong>React.js</strong> on different variety of projects.--}}
{{--                            </p>--}}

                            <h2>My way of working</h2>

                            <p>
                                Like every other person, I hate slow web apps and sites. In web development, my priorities
                                are <strong>code readability</strong> and <strong>performance</strong>. You can check my
                                post <a href="/posts/5-techniques-that-i-use-for-building-fast-websites" target="_blank">"5 techniques that
                                I use for building fast websites"</a> where I'm talking about it in details.
                            </p>

                            <p>
                                Websites that I'm working on are usually have the highest rate for the <strong>Lighthouse</strong>
                                tests or <strong>PageSpeed Insights</strong>. I always try making a product as <strong>SEO</strong> friendly as
                                possible.
                            </p>

                            <p>
                                In general, the code should be tested to make sure that behavior of the program works
                                as expected. The code should be clean and readable, so that others can read and
                                understand it.
                            </p>

                            <h2>Blog</h2>

                            <p>
                                In my free from coding time, I enjoy writing posts for my
                                <a href="/posts" target="_blank" title="Link to a blog">blog</a>
                                on programming related subjects and learn new things. I mostly share what I've learned along
                                the way and things that can help other developers strengthen their skills.
                            </p>

                            <p>
                                I'm <strong>not an expert</strong>, so I mostly share things that I do successfully or things
                                that I've learned and spend some time on research. I like writing about things that impress
                                me in <strong>software development</strong> or things that help me in problem solving.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <x-about.section isDark="true" header="Languages">
            <x-section-detail />
            <x-about.tech-section :techs="config('technologies.languages')"/>
        </x-about.section>

        <x-about.section header="Frameworks / CMS">
            <x-about.tech-section :techs="config('technologies.frameworks')"/>
        </x-about.section>

        <x-about.section isDark="true" header="Other technologies">
            <x-section-detail />
            <x-about.tech-section :techs="config('technologies.technologies')"/>
        </x-about.section>

        <x-about.section header="Personal skills">
            <x-about.tech-section :techs="config('technologies.skills')"/>
        </x-about.section>

        <x-about.section isDark="true" header="Latest projects" class="print:hidden">
            <x-section-detail />
            <x-about.projects-section/>
        </x-about.section>
    </div>

    <subscription></subscription>
@endsection
