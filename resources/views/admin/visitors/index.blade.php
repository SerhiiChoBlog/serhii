@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="title">Visitors</h1>

            <div class="table-container">
                <table class="table is-fullwidth is-hoverable is-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Views</th>
                            <th>IP</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Flag</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitors as $visitor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $visitor->page_views_sum_views }}</td>
                                <td>{{ $visitor->ip }}</td>
                                <td>{{ $visitor->country }}</td>
                                <td>{{ $visitor->city }}</td>
                                <td><img src="{{ asset("storage/flags/{$visitor->code}.png") }}" width="30" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
