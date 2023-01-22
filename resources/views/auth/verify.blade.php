@extends('layouts.main')

@section('content')
    <x-hero class="bg-gray-700" navbar="text-white" />

    <div class="container">
        <div class="my-20 bg-page-second border border-dotted border-border px-7 py-5 rounded-lg max-w-[800px] mx-auto opacity-90">
            <div class="flex items-center gap-4">
                <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>

                <div class="text-lg">
                    @if (session('resent'))
                        A fresh verification link has been sent to your email address
                    @else
                        Before proceeding, please check your email for a verification link.
                        If you did not receive the email, click the button below to request another.
                    @endif
                </div>
            </div>

            @if (!session('resent'))
                <form class="mt-4" method="POST" action="{{ route('verification.resend') }}">
                    @csrf

                    <button type="submit" class="bg-main text-white px-5 py-2 rounded-md">
                        Request another
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
