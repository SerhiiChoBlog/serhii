@extends('layouts.app')

@push('title', 'Information about Serhii Cho')
@push('description', "Serhii Cho is a Ukrainian web developer and blogger who is writing about enhancing your knowledge in creating fast and robust web apps")

@section('content')
    <x-hero
        class="relative bg-home-hero-sm lg:bg-home-hero w-full h-screen bg-blend-overlay bg-cover md:bg-fixed bg-top bg-no-repeat"
        navbar="text-white"
    >
        <div class="flex items-center justify-center absolute top-0 left-0 w-full h-screen bg-gradient-to-r from-transparent to-black/70">
            <subscription :remove-bg="true"></subscription>
        </div>
    </x-hero>
@endsection
