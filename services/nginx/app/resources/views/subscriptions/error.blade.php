@extends('layouts.main')

@push('title', 'Subscription error')
@push('description', "There is an error occurred while trying to subscribe to a mail list")

@section('content')
    <x-hero class="bg-linear-to-r from-gray-700 to-gray-600 text-white" />

    <div class="container py-10 lg:py-48 px-5 flex flex-col lg:flex-row gap-14 items-center">
        <div>
            <img
                src="{{ asset('img/subscription/error.svg') }}"
                alt="Letter"
                width="70"
                height="170"
                class="w-14 lg:w-24"
            >
        </div>
        <div>
            <h1 class="text-3xl lg:text-7xl font-black text-red-600 inline-block">
                Error
            </h1>

            <p class="text-xl">There is an error occurred while trying to subscribe to a mail list.</p>
            <p class="text-xl">Please, try again later.</p>
        </div>
    </div>
@endsection
