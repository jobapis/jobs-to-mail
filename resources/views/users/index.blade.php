@extends('layouts.app')

@section('title', config('app.description'))

@section('content')

@include('layouts.sitetitle')

<div class="row signup">
    <div class="col-lg-6 offset-lg-3 col-sm-8 offset-sm-2">
        <form method="POST" action="/users">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email">Email</label>
                @if (session('user'))
                    <input type="email" name="email" class="form-control" value="{{ session('user.email') }}" readonly />
                    <small>You are currently logged in. <a href="/logout">Logout</a> to create a search as a new user.</small>
                @else
                    <input type="email" name="email" class="form-control" placeholder="youremail@example.com" required/>
                @endif
            </div>
            <div class="form-group">
                <label for="keyword">Search Term</label>
                <input type="text" name="keyword" class="form-control" placeholder="Software engineering" required/>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" class="form-control" placeholder="Chicago, IL" required/>
            </div>

            @include('users.components.no-recruiters-checkbox')

            @include('users.components.submit')
        </form>
    </div>
</div>
@include('layouts.about')
@endsection
