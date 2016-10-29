@extends('layouts.app')

@section('title', config('app.description'))

@section('content')
<div class="row signup">
    <div class="col-lg-6 offset-lg-3 col-sm-8 offset-sm-2">
        <h1 class="page-header">{{ config('app.name') }}</h1>
        <p class="lead">{{ config('app.description') }}</p>
        <form method="POST" action="/auth/login">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="youremail@example.com" required/>
            </div>
            <div class="form-group">
                <input type="submit" value="Login" class="form-control btn btn-success btn-lg"/>
                <small><a href="https://www.sitepoint.com/passwordless-authentication-works/">We're passwordless. Here's why.</a></small>
            </div>
        </form>
    </div>
</div>
@endsection
