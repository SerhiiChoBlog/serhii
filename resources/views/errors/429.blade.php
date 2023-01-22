@extends('layouts.main')

@section('content')
    <x-error-page
        header="Looks like, you did Too Many Requests"
        :code="429"
    />
@endsection

