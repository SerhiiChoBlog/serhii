@extends('layouts.app')

@push('title', 'Information about Serhii Cho')
@push('description', "Serhii Cho is a Ukrainian web developer and blogger who is writing about enhancing your knowledge in creating fast and robust web apps")

@section('content')
    <x-hero
        class="relative bg-home-hero-sm lg:bg-home-hero w-full h-screen bg-blend-overlay bg-cover md:bg-fixed bg-top bg-no-repeat"
        navbar="text-white"
    />

    <div class="absolute left-0 right-0 top-0 bottom-0 bg-gradient-to-r from-transparent to-black/70"></div>

    <div class="absolute top-1/2 -translate-y-1/2 w-full">
        <subscription :remove-bg="true"></subscription>
    </div>
@endsection
