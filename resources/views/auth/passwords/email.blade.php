@extends('layouts.main')

@push('title', trans('common.reset_password') . ' | ')
@push('description', trans('common.reset_password_page_description'))

@section('content')
    <x-form.wrapper
        :title="trans('common.reset_password')"
        :intro="trans('common.reset_password_page_description')"
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
                        <x-form.label id="email">@lang('common.email')</x-form.label>
                        <x-form.input id="email"
                            type="email"
                            :value="old('email')"
                            name="email"
                            :placeholder="trans('common.email')"
                        />
                    </div>

                    <div class="text-center mt-5">
                        <x-form.button>
                            @lang('common.send_message')
                        </x-form.button>
                    </div>
                </form>
            @endif
        </div>
    </x-form.wrapper>
@endsection
