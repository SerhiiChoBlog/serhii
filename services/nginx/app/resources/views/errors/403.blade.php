@extends('layouts.main')

@section('content')
    <x-error-page
        :header="__($exception->getMessage() ?: 'Forbidden')"
        :code="403"
    />
@endsection
