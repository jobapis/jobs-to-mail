@extends('layouts.app')

@section('title', config('app.description'))

@section('content')
<div class="row signup">
    <div class="col-lg-6 offset-lg-3 col-sm-8 offset-sm-2">
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
            <div class="form-check">
                <label class="form-check-label disabled"
                       data-toggle="tooltip"
                       data-html="true"
                       data-placement="left"
                       title="Enable this option by contacting <a href='mailto:beta@jobstomail.com' target='_blank'>upgrade@jobstomail.com</a>">
                    <input type="checkbox" class="form-check-input" disabled>
                    <span class="">Don't include posts by recruiters</span>
                </label>
            </div>
            <div class="form-group">
                <input type="submit" value="Sign Up" class="form-control btn btn-success btn-lg"/>
                <small><a href="/terms">Terms/Privacy Policy</a></small>
            </div>
        </form>
    </div>
</div>
@include('layouts.about')
@endsection
