@extends('layouts.app')

@section('title', config('app.description'))

@section('content')
    <h1>Sign up</h1>
    <h3>Start receiving job listings today.</h3>
    <form method="POST" action="/users">
        {{ csrf_field() }}
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" required/>
        </div>
        <div>
            <label for="keyword">Search Term</label>
            <input type="text" name="keyword" required/>
        </div>
        <div>
            <label for="location">Location</label>
            <input type="text" name="location" required/>
        </div>
        <div>
            <input type="submit"/>
        </div>
    </form>
@endsection
