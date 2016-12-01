@extends('layouts.app')

@section('title', config('app.description'))

@section('content')

<div class="row premium-title">
    <div class="col-lg-6 offset-lg-3 col-sm-8 offset-sm-2">
        <h1 class="page-header">{{ config('app.name') }} Premium</h1>
        <p class="lead">Job board data for HR professionals</p>

        @include('layouts.flash-messages')
    </div>
</div>
<br>
<br>

<div class="row premium-signup">
    <div class="col-md-6">
        <h2 class="text-xs-center">Premium hiring data</h2>
        <p>JobsToMail Premium gives human resources teams, hiring managers, recruiters, and staffing professionals unrestricted access to hiring data from job boards across the web.</p>
        <p>Premium users get:</p>
        <ul>
            <li>A daily email full of the latest job listings from across the internet.</li>
            <li><strong>Exclude recruiters</strong> and staffing agencies if you'd like.</li>
            <li><strong>Downloadable spreadsheets</strong> with the latest job listing and company data.</li>
            <li>History of thier <strong>past job search data</strong>.</li>
            <li>Direct access to <strong>premium customer support</strong>.</li>
            <li>Listings collected from <strong>many job boards and aggregators</strong>.</li>
            <li>Up to <strong>10 search terms</strong> and locations per account.</li>
        </ul>
        <br>
    </div>

    <div class="col-md-6">
        <h2 class="text-xs-center">Sign up for Premium today</h2>
        <form method="POST" action="/users/premium">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" placeholder="First and Last Name" required/>
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
                <input type="submit" value="Continue" class="form-control btn btn-success btn-lg"/>
                <small><a href="/terms">Terms/Privacy Policy</a></small>
            </div>

        </form>
    </div>
</div>

<br><br>

<div class="row">
    <div class="col-md-8 offset-md-2">

        <div class="row premium-info">
            <div class="col-xs-8">
                <h3>Spot hiring trends</h3>
                <p>In your area or across the country.</p>
                <ul>
                    <li>Find out if certain jobs are being posted more often.</li>
                    <li>Build a list of companies that hire similar employees.</li>
                    <li>Prepare for changes in the workforce and labor market.</li>
                </ul>
            </div>

            <div class="col-xs-3 offset-xs-1">
                <img src="/img/graph.svg" class="img-fluid" alt="Hiring trends">
            </div>
        </div>
        <br><br>

        <div class="row premium-info">
            <div class="col-xs-3">
                <img src="/img/visible.svg" class="img-fluid" alt="New clients">
            </div>

            <div class="col-xs-8 offset-xs-1">
                <h3>Find new clients</h3>
                <p>Employers could be your next client.</p>
                <ul>
                    <li>Leads for independent recruiters and consultants.</li>
                    <li>Reach out with more data at your disposal.</li>
                    <li>Keep an eye on <a href="#provider-logos" class="font-weight-bold">{{ count(config('jobboards')) }} different job boards</a> at once.</li>
                </ul>
            </div>
        </div>
        <br><br>

        <div class="row premium-info">
            <div class="col-xs-8">
                <h3>Learn the hiring landscape</h3>
                <p>In your area or a new location.</p>
                <ul>
                    <li>Keep an eye out for your hiring competition.</li>
                    <li>Know which employers have been running job listings.</li>
                    <li>Find out which job listings have been open a long time.</li>
                </ul>
            </div>

            <div class="col-xs-3 offset-xs-1">
                <img src="/img/site-map.svg" class="img-fluid" alt="Hiring map">
            </div>
        </div>
        <br><br>

    </div>
</div>

@include('layouts.providers')

@endsection