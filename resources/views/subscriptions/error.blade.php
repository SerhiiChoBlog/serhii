@extends('layouts.app')

@push('title', 'Subscription error')
@push('description', "There is an error occurred while trying to subscribe to a mail list")

@section('content')
    <x-hero class="bg-gradient-to-r from-gray-700 to-gray-600 text-white" />

    <div class="container py-48 px-16 flex gap-14 items-center">
        <div>
            <img
                src="{{ asset('storage/subscription/error.svg') }}"
                alt="Letter"
                width="70"
                height="170"
            >
        </div>
        <div>
            <h1 class="text-[5rem] font-black text-red-600 inline-block">
                Error
            </h1>

            <p class="text-xl">There is an error occurred while trying to subscribe to a mail list.</p>
            <p class="text-xl">Please, try again later.</p>
        </div>
    </div>
@endsection
