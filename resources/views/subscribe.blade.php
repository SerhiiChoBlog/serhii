@extends('layouts.main')

@push('title', 'Information about Serhii Cho')
@push('description', "Serhii Cho is a Ukrainian web developer and blogger who is writing about enhancing your knowledge in creating fast and robust web apps")

@section('content')
    <x-hero
        class="relative w-full h-screen"
        navbar="text-white"
    >
        <div class="text-white bg-gradient-to-b from-gray-800 to-gray-700 flex items-center justify-center absolute top-0 left-0 w-full h-screen">
            <subscription></subscription>
        </div>
    </x-hero>
@endsection
