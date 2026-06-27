@extends('layouts.main')

@push('title', 'Information about Serhii Cho')
@push('description', 'Just another hacker summoning bugs while dabbling in all kinds of tech sorcery. I sprinkle open-source magic everywhere, and live inside Linux terminal')

@section('content')
    <x-hero
        class="relative w-full h-screen"
        navbar="text-white"
    >
        <div class="text-white bg-home-hero bg-cover flex items-center justify-center absolute top-0 left-0 w-full h-screen">
            <subscription></subscription>
        </div>
    </x-hero>
@endsection
