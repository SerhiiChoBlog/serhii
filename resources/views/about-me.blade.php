@extends('layouts.main')

@push('title', 'Information about Serhii Cho')
@push('description', "Serhii Cho is a web developer and blogger who is writing about enhancing your knowledge in creating fast and robust web apps")

@section('content')
    <x-hero
        mainTitle="Serhii Chornenkyi"
        subtitle="Serhii Cho is a web developer and blogger who is writing about<br />creating fast, robust, premium websites and applications"
        class="bg-gradient-to-r from-[#657ca1] via-[#445a7e] to-[#163249] text-white print:bg-none print:text-black"
    />

    <div class="print:mt-0 mt-2 text-xl">
        <section class="text-[1.2rem] px-2 lg:px-6 py-8 print:p-0">
            <div class="container">
                <div class="bg-page print:translate-y-0 -translate-y-16 rounded-xl pt-8">
                    <div class="grid grid-cols-1 gap-x-6 lg:grid-cols-[25%_1fr]">
                        <div class="relative">
                            <div class="print:w-full w-[250px] mx-auto rounded-lg print:initial sticky top-36 mb-6">
                                <img
                                    src="/storage/serhii-cho-min.webp"
                                    data-src="/storage/serhii-cho.webp"
                                    alt="Serhii Cho"
                                    class="my-auto rounded-lg mx-auto transition-all duration-500 shadow-lg"
                                    width="250"
                                    height="250"
                                />

                                <div>
                                    <x-download-pdf-button class="h-14 mt-8 shadow-lg !px-0 w-full" />
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

                            <h2>My way of working</h2>

                            <p>
                                I hate slow web apps and sites. In web development, my priorities
                                are <strong>code readability</strong> and <strong>performance</strong>. You can check my
                                post <a href="/posts/5-techniques-that-i-use-for-building-fast-websites" rel="noreferrer" target="_blank">"5 techniques that
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

                            <p>
                                When I am working on a product, my life becomes this product. If the client who hires me wants me
                                in his team, his product becomes the main focus of my life. This is why it's important to work on
                                something miningful, something that you can be proud of. I'm always trying to do my best and make
                                the product as good as possible. I'm always trying to find the best solution for the problem.
                            </p>

                            <h2>Blog</h2>

                            <p>
                                In my spare time, I enjoy writing articles for my
                                <a href="/posts" rel="noreferrer" target="_blank" title="Link to a blog">blog</a>
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

        <x-about.section isDark="true" header="Testimonials" class="min-h-[500px] print:hidden">
            <x-section-detail />

            <lazy-loading>
                <testimonials></testimonials>
            </lazy-loading>
        </x-about.section>

        <x-about.section header="Other Technologies">
            <x-about.tech-section :techs="config('technologies.technologies')" />
        </x-about.section>

        <x-about.section isDark="true" header="Personal Skills">
            <x-section-detail />
            <x-about.tech-section :techs="config('technologies.skills')" />
        </x-about.section>

        <x-about.section header="Latest Projects" class="min-h-[400px] print:hidden">
            <work-projects></work-projects>
        </x-about.section>

        <x-about.section isDark="true" header="Latest Books I've Read">
            <x-section-detail />
            <books-read></books-read>
        </x-about.section>
    </div>
@endsection
