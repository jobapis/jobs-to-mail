@extends('layouts.app')

@section('title', config('app.description'))

@section('content')

@include('users/components/premium-title')

<div class="row premium-signup">
    <div class="col-md-6">
        <h2 class="text-xs-center">Job board data for HR professionals</h2>
        <p>JobsToMail Premium gives human resources teams, hiring managers, recruiters, and staffing professionals unrestricted access to hiring data from job boards across the web.</p>
        <p>Premium users get:</p>
        <ul>
            <li>A daily email full of the latest job listings from across the internet.</li>
            <li><strong>Downloadable spreadsheets</strong> with the latest job listing and company data.</li>
            <li>History of <strong>past job search data</strong>.</li>
            <li><strong>Filter listings by recruiters</strong> and staffing agencies.</li>
            <li>Direct access to <strong>premium customer support</strong>.</li>
            <li>Up to <strong>10 search terms</strong> and locations per account.</li>
        </ul>
    </div>

    <div class="col-md-6">
        <h2 class="text-xs-center">Sign up for Premium today</h2>
        <form method="POST" action="/users/premium">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Jane Smith" required/>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                @if (session('user'))
                    <input type="email" name="email" class="form-control" value="{{ session('user.email') }}" readonly />
                    <small>You are currently logged in. <a href="/logout">Logout</a> to use another email address.</small>
                @else
                    <input type="email" name="email" class="form-control" placeholder="youremail@example.com" required/>
                @endif
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" class="form-control" placeholder="Chicago, IL" required/>
            </div>
            <div class="form-group">
                <label for="employer">Employer</label>
                <input type="text" name="employer" class="form-control" placeholder="Acme, Inc." required/>
            </div>
            <div class="form-group">
                <input type="submit" value="Continue" class="form-control btn btn-success btn-lg"/>
            </div>
        </form>
    </div>
</div>

<div class="row premium-signup">
    <div class="col-md-12">
        <p class="h2 text-xs-center">All this for only</p>
        <p class="h1 text-xs-center">
            <span class="tag tag-success">$19.99</span><small class="text-muted"> per month</small>
        </p>
    </div>
</div>

@include('users/components/premium-info')

@include('layouts.providers')

@endsection
