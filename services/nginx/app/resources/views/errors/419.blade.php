@extends('layouts.main')

@section('content')
    <x-error-page
        header="Looks like, this page has expired"
        :code="419"
    />
@endsection
