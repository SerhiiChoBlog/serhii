@extends('layouts.app')

@push('title', 'Information about Serhii Cho')
@push('description', "Serhii Cho is a Ukrainian web developer and blogger who is writing about enhancing your knowledge in creating fast and robust web apps")

@section('content')
    <div class="bg-gradient-to-r from-gray-800 to-gray-700 h-screen">
        <x-hero
            class="bg-gradient-to-r from-gray-800 to-gray-700 text-white"
        />

        <div class="absolute top-1/2 -translate-y-1/2 w-full">
            <subscription></subscription>
        </div>
    </div>
@endsection
