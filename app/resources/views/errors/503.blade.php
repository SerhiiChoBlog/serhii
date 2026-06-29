@extends('layouts.main')

@section('content')
    <x-error-page
        header="Woops, seems like Service Unavailable"
        :code="503"
    />
@endsection
