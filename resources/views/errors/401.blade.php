@extends('layouts.app')

@section('content')
    <x-error-page
        header="Looks like you unauthorized"
        :code="401"
    />
@endsection
