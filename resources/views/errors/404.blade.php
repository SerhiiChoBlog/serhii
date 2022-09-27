@extends('layouts.app')

@push('title', '404 | Serhii Cho')
@push('description', 'Page not found')

@section('content')
    <x-error-page
        header="Looks like you can't find a page you need."
        :code="404"
    />
@endsection
