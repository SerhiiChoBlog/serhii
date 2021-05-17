@extends('layouts.admin')

@section('content')

<div class="container">
    <nav class="level">
        <div class="level-item has-text-centered">
            <div>
                <p class="heading">Last visit</p>
                <p class="title">{{ $last_visit }}</p>
            </div>
        </div>
        <div class="level-item has-text-centered">
            <div>
                <p class="heading">Visitors</p>
                <p class="title">{{ $visitors_count }}</p>
            </div>
        </div>
        <div class="level-item has-text-centered">
            <div>
                <p class="heading">-</p>
                <p class="title">-</p>
            </div>
        </div>
        <div class="level-item has-text-centered">
            <div>
                <p class="heading">-</p>
                <p class="title">-</p>
            </div>
        </div>
    </nav>
</div>

@endsection
