@extends('layouts.main')

@push('title', 'Information about Serhii Cho')
@push('description', "Serhii Cho is a web developer and blogger who is writing about enhancing your knowledge in creating fast and robust web apps")

@section('content')
    <x-hero
        mainTitle="Serhii Cho"
        subtitle="Serhii Cho is a web developer and blogger who is writing about<br />creating fast, robust, premium websites and applications"
        class="bg-linear-to-r from-[#657ca1] via-[#445a7e] to-[#163249] text-white print:bg-none print:text-black"
    />

    <div class="print:mt-0 mt-2 text-xl">
        <section class="text-[1.2rem] px-2 lg:px-6 py-8 print:p-0">
            <div class="container">
                <div class="bg-page print:translate-y-0 -translate-y-16 rounded-xl pt-8">
                    <div class="grid grid-cols-1 gap-x-6 lg:grid-cols-[25%_1fr]">
                        <div class="print:w-full w-[250px] mx-auto rounded-lg top-36 mb-6">
                            <img
                                src="/storage/serhii-cho.webp"
                                alt="Serhii Cho"
                                class="my-auto rounded-lg mx-auto transition-all duration-500 shadow-lg"
                                width="250"
                                height="250"
                            />
                        </div>

                        <div class="about-me prose-xl prose-h2:mb-6 prose-h2:mt-0">
                            <x-about.intro />
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
