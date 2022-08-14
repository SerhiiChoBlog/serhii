@extends('layouts.app')

@section('title', 'Subscribed to Serhii Cho')
@section('description', "Your subscription has been confirmed and you've been added to the list")

@section('content')
    <x-hero class="bg-gradient-to-r from-gray-700 to-gray-600 text-white" />

    <div class="container py-48 px-16 flex gap-14 items-center">
        <div>
            <img
                src="{{ asset('storage/subscription/letter.svg') }}"
                alt="Letter"
                width="200"
                height="115"
            >
        </div>
        <div>
            <h1
                class="text-[5rem] font-black text-main inline-block"
                style="
                    background: -webkit-linear-gradient(45deg, #d074a2, #2a4b67);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                "
            >
                Subscribed
            </h1>

            <p class="text-xl"></p>
            <p class="text-xl">Your subscription has been confirmed, and you've been added to the list.</p>
            <p class="text-xl">You'll receive a letter every time a new post is published. 🥳</p>
        </div>
    </div>
@endsection
