@extends('layouts.main')

@push('title', 'Login to your account')
@push('description', 'Login to your account to stay in touch')

@section('content')
    <x-hero class="bg-gray-700" navbar="text-white" />

    <x-form.wrapper
        title="Login"
        intro="Login to your account to unlock some extra features only for registered users"
        infoTitle="Don't have an account?"
        infoIntro="If you don't have an account yet, you can register one in a few seconds"
        img="login.webp"
    >
        <x-slot name="info">
            <div class="text-white">
                <a
                    href="{{ route('register') }}"
                    class="mt-5 inline-block bg-black/70 hover:bg-black transition-colors text-white py-4 px-10 rounded-full shadow-lg"
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

                <div class="pt-1">
                    <x-form.button>Login</x-form.button>

                    <x-sign-with />

                    <div class="mt-6">
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
