@extends('layouts.app')

@push('title', 'Create an account')
@push('description', 'Create an account to unlock extra features only for registered users')

@section('content')
    <x-hero class="bg-gray-700" navbar="text-white" />

    <x-form.wrapper
        title="Register"
        intro="Create an account to unlock extra features"
        infoTitle="Already have an account?"
        infoIntro="Login to your account to stay in touch"
        img="register.jpg"
    >
        <x-slot name="info">
            <div class="text-white">
                <a
                    href="{{ route('login') }}"
                    class="mt-5 inline-block bg-decor text-white py-4 px-20 rounded-full shadow-lg"
                >
                    Login
                </a>
            </div>
        </x-slot>

        @if (session('success'))
            <div class="text-center text-green-700" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="space-y-5">
                <div>
                    <x-form.label id="email">Email</x-form.label>
                    <x-form.input
                        id="email"
                        :value="old('email')"
                        placeholder="Enter email"
                        name="email"
                        type="email"
                    />
                </div>

                <div>
                    <x-form.label id="password">Password</x-form.label>

                    <x-form.input
                        id="password"
                        type="password"
                        placeholder="Enter password"
                        name="password"
                    />
                </div>

                <div class="pt-4">
                    <x-form.button>Register</x-form.button>
                </div>
            </div>
        </form>
    </x-form.wrapper>
@endsection
