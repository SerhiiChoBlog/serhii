@extends('layouts.app')

@push('title', trans('common.reset_password') . ' | ')
@push('description', trans('common.reset_password_page_description'))

@section('content')

<x-form.wrapper :title="trans('common.reset_password')">
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="space-y-5 mt-5">
            <div>
                <x-form.label id="email">@lang('common.email')</x-form.label>
                <x-form.input id="email"
                    type="email"
                    name="email"
                    :value="$email ?? old('email')"
                    :placeholder="trans('common.email')"
                />
            </div>

            <div>
                <x-form.label id="password">@lang('common.password')</x-form.label>
                <x-form.input id="password"
                    type="password"
                    name="password"
                    :placeholder="trans('common.password')"
                />
            </div>

            <div>
                <x-form.label id="password-confirm">@lang('common.confirm_password')</x-form.label>
                <x-form.input id="password-confirm"
                    type="password"
                    name="password_confirmation"
                    :placeholder="trans('common.confirm_password')"
                />
            </div>

            <div class="text-center !mt-7">
                <x-form.button>
                    @lang('common.reset_password')
                </x-form.button>
            </div>
        </div>
    </form>
</x-form.wrapper>
@endsection
