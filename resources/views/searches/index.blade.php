@extends('layouts.app')

@section('title', config('app.description'))

@section('content')
    <div class="row searches">
        <div class="col-sm-8 offset-sm-2">
            <h1>Your Searches</h1>
            @foreach($searches as $search)
                <div class="card card-block">
                    <h4 class="card-title">"{{ $search->keyword }}"</h4>
                    <p>Location: "{{ $search->location }}"</p>
                    <p><a href="/searches/{{ $search->id }}/unsubscribe" class="card-link">Unsubscribe</a></p>
                </div>
            @endforeach
            <p><a href="/">Back to Homepage</a></p>
        </div>
    </div>
@endsection
