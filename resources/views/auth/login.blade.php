@extends('layouts.app')

@push('title', 'Login to your account')
@push('description', 'Login to your account to stay in touch')

@section('content')
    <x-hero class="bg-gray-700" navbar="text-white" />

    <x-form.wrapper
        title="Login"
        intro="Login to your account to stay in touch"
        infoTitle="Don't have an account?"
        infoIntro="Create an account to unlock extra features"
        img="login.jpg"
    >
        <x-slot name="info">
            <div class="text-white">
                <a
                    href="{{ route('register') }}"
                    class="mt-5 inline-block bg-decor text-white py-4 px-10 rounded-full shadow-lg"
                >
                    Register an account
                </a>
            </div>
        </x-slot>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="space-y-5">
                <div>
                    <x-form.label id="email">Email</x-form.label>
                    <x-form.input
                        id="email"
                        :value="old('email') ?? request('email')"
                        placeholder="Enter email"
                        name="email"
                    />
                </div>

                <div>
                    <x-form.label id="password">Password</x-form.label>
                    <x-form.input
                        id="password"
                        type="password"
                        placeholder="Enter your password" name="password"
                    />
                </div>

                <div class="flex gap-2 px-1">
                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                    />

                    <label for="remember" class="text-font-second">
                        Remember me
                    </label>
                </div>

                <div class="pt-4">
                    <x-form.button>Login</x-form.button>

                    <div class="pt-7">
                        <x-question-link
                            question="Forgot password?"
                            :link="route('password.request')"
                            title="Reset your password"
                        />
                    </div>
                </div>
            </div>
        </form>
    </x-form.wrapper>
@endsection
