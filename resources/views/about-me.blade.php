@extends('layouts.main')

@push('title', 'Information about Serhii Cho')
@push('description', "Serhii Cho is a developer and blogger who is writing about enhancing your knowledge in creating fast and robust web apps")

@section('content')
    <x-hero
        mainTitle="Serhii Cho"
        subtitle="Serhii Cho is a developer and blogger who is writing about<br />creating fast, robust, premium websites and applications"
        class="bg-linear-to-r from-[#657ca1] via-[#445a7e] to-[#163249] text-white"
    />

    <div class="mt-2 text-xl">
        <section class="text-[1.2rem] px-2 lg:px-6 py-8">
            <div class="container">
                <div class="bg-page -translate-y-16 rounded-xl pt-8">
                    <div class="grid grid-cols-1 gap-x-6 lg:grid-cols-[25%_1fr]">
                        <div class="w-[250px] mx-auto rounded-lg top-36 mb-6">
                            <img
                                src="/storage/serhii-cho.webp"
                                alt="Serhii Cho"
                                class="my-auto rounded-lg mx-auto transition-all duration-500 shadow-lg"
                                width="250"
                                height="250"
                            />
                        </div>

                        <div class="about-me prose-xl prose-h2:mb-6 prose-h2:mt-0">
                            <p>
                                I spent 5 years working at a company based in the Netherlands. After that, I worked as a freelancer on various projects.
                            </p>

                            <p>
                                Today I mostly work on developer tools. This includes an interpreter called
                                <a href="https://github.com/textwire/textwire" target="_blank">Textwire</a>,
                                libraries for Go, PHP, and TypeScript, editor and browser extensions, and
                                tooling around LSP and Tree-sitter. Most of this work is open source and lives on
                                <a href="https://github.com/SerhiiCho" target="_blank">GitHub</a>.
                            </p>

                            <p>
                                Sometimes I post coding videos on
                                <a href="https://www.youtube.com/@serhiicho" target="_blank">YouTube</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <x-about.section :isDark="true" class="min-h-[500px]">
            <x-section-detail />

            <lazy-loading>
                <testimonials></testimonials>
            </lazy-loading>
        </x-about.section>

        <x-about.section>
            <x-about.tech-section :techs="config('technologies.technologies')" />
        </x-about.section>
    </div>
@endsection
