@extends('layouts.main')

@push('title', 'Information about Serhii Cho')
@push('description', "Serhii Cho is a web developer and blogger who is writing about enhancing your knowledge in creating fast and robust web apps")

@section('content')
    <x-hero
        mainTitle="Serhii Cho"
        subtitle="Serhii Cho is a web developer and blogger who is writing about<br />creating fast, robust, premium websites and applications"
        class="bg-gradient-to-r from-[#657ca1] via-[#445a7e] to-[#163249] text-white print:bg-none print:text-black"
    />

    <div class="print:mt-0 mt-2 text-xl">
        <section class="text-[1.2rem] px-2 lg:px-6 py-8 print:p-0">
            <div class="container">
                <div class="bg-page print:translate-y-0 -translate-y-16 rounded-xl pt-8">
                    <div class="grid grid-cols-1 gap-x-6 lg:grid-cols-[25%_1fr]">
                        <div class="relative">
                            <div class="print:w-full w-[250px] mx-auto rounded-lg print:initial sticky print:static top-36 mb-6">
                                <img
                                    src="/storage/serhii-cho-min.webp"
                                    data-src="/storage/serhii-cho.webp"
                                    alt="Serhii Cho"
                                    class="my-auto rounded-lg mx-auto transition-all duration-500 shadow-lg"
                                    width="250"
                                    height="250"
                                />
                            </div>
                        </div>

                        <div class="about-me prose-xl prose-h2:mb-6 prose-h2:mt-0">
                            <h2>Experience</h2>

                            <x-about.intro />

                            <p>
                                I worked with various integration services, including <strong>Megaplan CRM</strong> and
                                <strong>Exact Online</strong>, as well as payment systems like <strong>Mollie</strong>,
                                <strong>Bitpay</strong>, <strong>Portmone</strong>, and <strong>WayForPay</strong>. My development experience includes building
                                applications within <strong>Podman</strong> containers, creating SPAs using <strong>Vue</strong> and
                                <strong>React</strong>, and creating websites with things like <strong>WordPress</strong>,
                                <strong>Laravel</strong>, and <strong>Go</strong>.
                            </p>

                            <p>
                                I'm not fixed on a specific programming language or framework, instead I'm open to use
                                whatever is needed to get the most optimal solution for a specific task.
                            </p>

                            <p>
                                In my free time, I actively contribute to open-source projects, many of which are available on my
                                <a href="https://github.com/SerhiiCho" target="_blank">GitHub</a>. Notable projects include libraries
                                like <a href="https://github.com/textwire/textwire" target="_blank">Textwire</a> and
                                <a href="https://github.com/SerhiiCho/timeago" target="_blank">Timeago</a> for the Go programming
                                language. I also maintain and utilize several PHP libraries that play a significant role in my personal
                                and professional projects.
                            </p>

                            <p>
                                Additionally, I have worked on a variety of projects for companies in the
                                <strong>business</strong> and <strong>e-commerce</strong> sectors. My experience includes developing
                                tools for document generation, employee management systems, client communication platforms, chatbots,
                                and a wide range of web APIs to streamline business operations.
                            </p>

                            <h2>My Way of Working</h2>

                            <p>
                                I strive to build web applications that are not only fast but also highly efficient. My development priorities
                                center around <strong>code readability</strong> and <strong>performance</strong>. I firmly believe that clean,
                                maintainable code leads to better products. If you're interested, you can read more about my approach in my
                                post <a href="/posts/5-techniques-that-i-use-for-building-fast-websites" rel="noreferrer" target="_blank">
                                "5 Techniques That I Use for Building Fast Websites"</a>, where I explain these principles in detail.
                            </p>

                            <p>
                                I believe that quality software should be <strong>tested</strong> to guarantee consistent, reliable functionality.
                                Writing <strong>clean, readable code</strong> allows other developers to easily understand, maintain, and expand
                                the project. This collaborative approach keeps the project future-proof and adaptable to changing needs.
                            </p>

                            <p>
                                When I work on a project, I fully immerse myself in it. The client's product becomes my top priority, and I treat
                                it as if it were my own. For me, it's crucial to work on something meaningful—something I can be proud of.
                                I always aim for the best possible outcome, finding the most effective and efficient solution to every challenge
                                that arises.
                            </p>

                            <h2>Sharing Knowledge</h2>

                            <p>
                                In my spare time, I enjoy sharing my knowledge and experiences through my
                                <a href="/posts" rel="noreferrer" target="_blank" title="Link to the blog">blog</a>.
                                I write about programming concepts, development techniques, and solutions to
                                real-world challenges. My goal is to provide useful insights that help other
                                developers strengthen their skills and overcome obstacles more effectively.
                            </p>

                            <p>
                                I don't claim to be an expert, but I strive to document my learning journey.
                                I share both successes and hard-earned lessons, often after spending significant
                                time researching and solving complex problems. I find joy in writing about concepts
                                in <strong>software development</strong> that surprise or inspire me, as well as
                                creative solutions to technical challenges.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <x-about.section
            :isDark="true"
            header="Languages"
            subheader="Programming languages that I've used in my work and projects."
        >
            <x-section-detail />
            <x-about.tech-section :techs="config('technologies.languages')" />
        </x-about.section>

        <x-about.section
            header="Frameworks / CMS"
            subheader="Frameworks and CMS that I've used in my work and projects."
        >
            <x-about.tech-section :techs="config('technologies.frameworks')" />
        </x-about.section>

        <x-about.section
            :isDark="true"
            header="Testimonials"
            subheader="What some of my best clients and colleagues have to say about me."
            class="min-h-[500px] print:hidden"
        >
            <x-section-detail />

            <lazy-loading>
                <testimonials></testimonials>
            </lazy-loading>
        </x-about.section>

        <x-about.section
            header="Other Technologies"
            subheader="Other technologies that I've used in my work and projects."
        >
            <x-about.tech-section :techs="config('technologies.technologies')" />
        </x-about.section>

        <x-about.section
            :isDark="true"
            header="Personal Skills"
            subheader="Skills that I've developed over the years that help me in my work."
        >
            <x-section-detail />
            <x-about.tech-section :techs="config('technologies.skills')" />
        </x-about.section>

        <x-about.section
            header="Latest Projects"
            subheader="Latest projects that I've worked on. Some of them are not included due to NDA."
            class="min-h-[400px] print:hidden"
        >
            <work-projects></work-projects>
        </x-about.section>

        <x-about.section
            :isDark="true"
            header="Latest Books I've Read"
            subheader="The latest software-development books that I've read"
            class="print:hidden"
        >
            <x-section-detail />

            <lazy-loading>
                <books-read></books-read>
            </lazy-loading>
        </x-about.section>

        <x-about.section
            :isDark="false"
            header="Print this page"
            subheader="You can download this page as PDF file."
            class="print:hidden"
        >
            <div class="text-center">
                <x-download-pdf-button class="h-14 my-10 mx-auto shadow-lg" />
            </div>
        </x-about.section>
    </div>
@endsection
