@extends('layouts.main')

@push('title', 'Reset password')
@push('description', 'Enter your new password')

@section('content')
    <x-hero class="bg-gray-700" navbar="text-white" />

    <x-form.wrapper
        title="Reset password"
        intro="Enter your new password"
    >
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="space-y-5 mt-5">
                <div>
                    <x-form.label id="email">Email</x-form.label>
                    <x-form.input id="email"
                        type="email"
                        name="email"
                        :value="$email ?? old('email')"
                        placeholder="Enter email password"
                    />
                </div>

                <div>
                    <x-form.label id="password">Password</x-form.label>
                    <x-form.input id="password"
                        type="password"
                        name="password"
                        placeholder="Enter password"
                    />
                </div>

                <div>
                    <x-form.label id="password-confirm">
                        Confirm password
                    </x-form.label>
                    <x-form.input id="password-confirm"
                        type="password"
                        name="password_confirmation"
                        placeholder="Enter password confirmation"
                    />
                </div>

                <div class="text-center !mt-7">
                    <x-form.button>
                        Save new password
                    </x-form.button>
                </div>
            </div>
        </form>
    </x-form.wrapper>
@endsection
