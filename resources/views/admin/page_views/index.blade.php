@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1 class="title">Page views</h1>

            <div class="table-container">
                <table class="table is-fullwidth is-hoverable is-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Page slug</th>
                            <th>Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($views as $view)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $view->slug }}</td>
                                <td>{{ $view->views }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
