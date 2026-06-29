@extends('layouts.main')

@section('content')
    <x-form.wrapper
        :title="trans('common.confirm_password')"
        :intro="trans('common.confirm_password_before_continuing')"
    >
        <div>
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div>
                    <x-form.label id="password">@lang('common.password')</x-form.label>
                    <x-form.input id="password"
                        type="password"
                        name="password"
                        :placeholder="trans('common.password')"
                    />
                </div>

                <div class="text-center">
                    <x-form.button>
                        @lang('common.confirm_password')
                    </x-form.button>
                </div>

                <div class="text-center">
                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="text-main hover:underline"
                        >
                            @lang('common.forgot_password')
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </x-form.wrapper>
@endsection
