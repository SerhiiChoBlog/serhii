@extends('layouts.app')

@push('title', 'Information about Serhii Cho')
@push('description', "Serhii Cho is a Ukrainian web developer and blogger who is writing about enhancing your knowledge in creating fast and robust web apps")

@section('content')
    <x-hero
        mainTitle="Serhii Chornenkyi"
        subtitle="Serhii Cho is a Ukrainian web developer and blogger who is writing about<br />enhancing your knowledge in creating fast and robust web apps"
        class="bg-gradient-to-r from-[#163249] via-[#657ca1] to-[#657ca1] text-white print:bg-none print:text-black"
    />

    <div class="mt-2 text-xl">
        <section class="text-[1.2rem] px-2 lg:px-6 py-8 ">
            <div class="container">
                <div class="bg-page -translate-y-16 rounded-xl pt-8">
                    <div class="grid grid-cols-1 gap-x-6 lg:grid-cols-[25%_1fr]">
                        <div class="relative">
                            <div class="w-[250px] mx-auto rounded-lg sticky top-20 mb-6">
                                <img
                                    src="/storage/serhii-cho-min.jpg"
                                    data-src="/storage/serhii-cho.jpg"
                                    alt="Serhii Cho"
                                    class="my-auto rounded-lg mx-auto transition-all duration-500 shadow-lg"
                                    width="250"
                                    height="250"
                                />

                                <div>
                                    <x-download-pdf-button class="h-16 mt-10 shadow-lg !px-0 w-full" />
                                </div>
                            </div>
                        </div>

                        <div class="about-me prose-xl prose-h2:mb-6 prose-h2:mt-0">
                            <h2>Experience</h2>

                            <x-about.intro />

                            <p>
                                I've worked with integration services like <strong>Megaplan CRM</strong>,
                                <strong>Exact Online</strong>, payment systems like <strong>Mollie</strong>,
                                <strong>Bitpay</strong> and <strong>WayForPay</strong>. I've built apps in <strong>Docker</strong>
                                containers, SPAs with <strong>Vue</strong>, <strong>React</strong>, and websites with
                                <strong>WordPress</strong> and <strong>Laravel</strong>. Likewise, I've done tons of
                                different work for companies in <strong>business</strong> and <strong>e-commerce</strong>
                                segment. Building programs and interfaces for generating different types of documents,
                                programs for stuff management, communication with clients, chat bots and tons of web APIs.
                            </p>

                            <h2>Looking for job</h2>

                            <p>
                                I'm looking forward to work in product company from 🇪🇺 🇺🇸 🇨🇦 🇦🇺 🏴󠁧󠁢󠁥󠁮󠁧󠁿 by a contract.
                                I'll be comfortable to work remotely <strong>7 hours a day</strong> or less.
                                I'm also ready to potentially relocate from Ukraine and work in the office in the future.
                            </p>

                            <p>
                                I'll be glad to work as a full-stack developer with <strong>Laravel, Vue and React</strong>.
                                Alternatively, I can work as a backend developer, or a frontend developer as I have lots of experience in web page design.
                            </p>

                            <h2>My way of working</h2>

                            <p>
                                I hate slow web apps and sites. In web development, my priorities
                                are <strong>code readability</strong> and <strong>performance</strong>. You can check my
                                post <a href="/posts/5-techniques-that-i-use-for-building-fast-websites" target="_blank">"5 techniques that
                                I use for building fast websites"</a> where I'm talking about it in details.
                            </p>

                            <p>
                                Websites that I'm working on are usually have the highest rate for the <strong>Lighthouse</strong>
                                tests or <strong>PageSpeed Insights</strong>. I always try making a product as <strong>SEO</strong> friendly as
                                possible on developer side.
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
            <x-about.tech-section :techs="config('technologies.languages')" />
        </x-about.section>

        <x-about.section header="Frameworks / CMS">
            <x-about.tech-section :techs="config('technologies.frameworks')" />
        </x-about.section>

        <x-about.section isDark="true" header="Other technologies">
            <x-section-detail />
            <x-about.tech-section :techs="config('technologies.technologies')" />
        </x-about.section>

        <x-about.section header="Personal skills">
            <x-about.tech-section :techs="config('technologies.skills')" />
        </x-about.section>

        <x-about.section isDark="true" header="Latest projects" class="print:hidden">
            <x-section-detail />
            <x-about.projects-section />
        </x-about.section>
    </div>

    <subscription></subscription>
@endsection
