@extends('layouts.app')

@section('title', config('app.description'))

@section('content')

@include('layouts.sitetitle')

<div class="row confirm">
    <div class="col-lg-6 offset-lg-3 col-sm-8 offset-sm-2">
        <form method="POST" action="/auth/confirm">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email">Login Token</label>
                <input type="text" name="token" class="form-control" placeholder="Check your email for this token." required/>
            </div>
            <div class="form-group">
                <input type="submit" value="Login" class="form-control btn btn-success btn-lg"/>
                <small><a href="/login">Send me a new token</a>.</small>
            </div>
        </form>
    </div>
</div>
@endsection
