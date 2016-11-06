@extends('layouts.app')

@section('title', config('app.description'))

@section('content')

@include('layouts.sitetitle')

<div class="row searches">
    <div class="col-lg-8 offset-lg-2 col-sm-12 offset-sm-0">
        <h3>Your Searches</h3>
        @foreach($searches as $search)
            <div class="card card-block">
                <h4 class="card-title">"{{ $search->keyword }}"</h4>
                <p>Location: "{{ $search->location }}"</p>
                @include('searches.components.search-dates')
                @include('searches.components.no-recruiters-checkbox')
                @include('searches.components.action-links')
            </div>
        @endforeach
        <div><a href="/" class="btn btn-block btn-outline-success btn-lg">Add Search</a></div>
    </div>
</div>

@endsection
