@extends('layouts.app')

@section('title', config('app.description'))

@section('content')
<div class="row signup">
    <div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">
        <h1 class="page-header">{{ config('app.name') }}</h1>
        <p class="lead">{{ config('app.description') }}</p>
        <form method="POST" action="/users">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="youremail@example.com" required/>
            </div>
            <div class="form-group">
                <label for="keyword">Search Term</label>
                <input type="text" name="keyword" class="form-control" placeholder="Software engineering" required/>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" class="form-control" placeholder="Chicago, IL" required/>
            </div>
            <div class="form-group">
                <input type="submit" value="Sign Up" class="form-control btn btn-success"/>
            </div>
        </form>
    </div>
</div>
@include('layouts.about')
@endsection
