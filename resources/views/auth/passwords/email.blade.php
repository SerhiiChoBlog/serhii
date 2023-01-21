@extends('layouts.main')

@push('title', 'Reset password')
@push('description', 'Enter your email address and we will send you a link to reset your password')

@section('content')
    <x-hero class="bg-gray-700" navbar="text-white" />

    <x-form.wrapper
        title="Reset password"
        intro="Enter your email address and we will send you a link to reset your password"
    >
        <div>
            @if (session('status'))
                <div class="text-center text-font-second font-bold" role="alert">
                    {{ session('status') }}
                </div>
            @else
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div>
                        <x-form.label id="email">Email</x-form.label>
                        <x-form.input id="email"
                            type="email"
                            :value="old('email')"
                            name="email"
                            placeholder="Enter your email"
                        />
                    </div>

                    <div class="text-center mt-5">
                        <x-form.button>
                            Send reset password link
                        </x-form.button>
                    </div>
                </form>
            @endif
        </div>
    </x-form.wrapper>
@endsection
