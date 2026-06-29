@extends('layouts.main')

@section('content')
    <x-error-page
        header="Woops, seems like a Server Error"
        :code="500"
    />
@endsection
