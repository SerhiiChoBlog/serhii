@extends('layouts.app')

@push('title', 'Information about Serhii Cho')
@push('description', "Serhii Cho is a Ukrainian web developer and blogger who is writing about enhancing your knowledge in creating fast and robust web apps")

@section('content')
    <x-hero
        class="relative w-full h-screen"
        navbar="text-white"
    >
        <div class="bg-gradient-to-b from-[#163249] via-[#657ca1] to-[#657ca1] flex items-center justify-center absolute top-0 left-0 w-full h-screen">
            <subscription :remove-bg="true"></subscription>
        </div>
    </x-hero>
@endsection
