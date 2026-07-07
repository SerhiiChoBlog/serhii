@extends('layouts.main')

@push('title', 'Unsubscribed')
@push('description', "Your subscription has been removed, I will be missing you so much. If you change your mind, you will be welcomed back")

@section('content')
    <x-hero class="bg-linear-to-r from-gray-700 to-gray-600 text-white" />

    <div class="container py-48 px-16 flex gap-14 items-center">
        <div>
            <img
                src="{{ asset('img/subscription/declined.svg') }}"
                alt="Letter"
                width="70"
                height="170"
            >
        </div>
        <div>
            <h1 class="text-[5rem] font-black text-red-600 inline-block">
                Unsubscribed
            </h1>

            <p class="text-xl">Your subscription has been removed, I will be missing you so much 😔.</p>
            <p class="text-xl">If you change your mind, you will be welcomed back.</p>
        </div>
    </div>
@endsection
