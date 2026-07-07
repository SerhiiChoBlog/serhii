@extends('layouts.main')

@section('content')
    <x-error-page
        header="Looks like you can't find a page you need."
        :code="404"
    />
@endsection
