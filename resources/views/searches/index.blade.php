@extends('layouts.app')

@section('title', config('app.description'))

@section('content')

@include('layouts.sitetitle')

<div class="row searches">
    <div class="col-lg-8 offset-lg-2 col-sm-12 offset-sm-0">
        <div class="card card-block" style="margin: 30px 0;">
            @include('advertisements.upgrade')
        </div>

        <h3>Your Searches</h3>
        @foreach($searches as $search)
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">"{{ $search->keyword }} in {{ $search->location }}"</h4>
                @include('searches.components.search-dates')
                @include('searches.components.no-recruiters-checkbox')
                @include('searches.components.action-links')
                </div>
            </div>
        @endforeach
        <div><a href="/" class="mt-3 btn btn-block btn-outline-success btn-lg">Add Search</a></div>
    </div>
</div>

@endsection
