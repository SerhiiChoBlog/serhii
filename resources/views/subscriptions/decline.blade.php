@extends('layouts.main')

@push('title', 'Decline subscription')
@push('description', "Your subscription has not been confirmed, therefore it was remove from the list")

@section('content')
    <x-hero class="bg-linear-to-r from-gray-700 to-gray-600 text-white" />

    <div class="container py-10 lg:py-48 px-5 flex flex-col lg:flex-row gap-14 items-center">
        <div>
            <img
                src="{{ asset('img/subscription/declined.svg') }}"
                alt="Cancel icon"
                width="70"
                height="170"
                class="w-24 md:w-44 lg:w-32"
            >
        </div>
        <div>
            <h1 class="text-3xl lg:text-7xl font-black text-red-600 inline-block">
                Declined
            </h1>

            <p class="text-xl">Your subscription has not been confirmed, therefore it has been removed from the email list.</p>
            <p class="text-xl">I hope, you will change your mind and re-subscribe 😔</p>
        </div>
    </div>
@endsection
