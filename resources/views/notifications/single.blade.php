@extends('layouts.app')

@section('title', config('app.description'))

@section('content')

@include('layouts.sitetitle')

<div class="row searches">
    <div class="col-lg-8 offset-lg-2 col-sm-12 offset-sm-0">
        <div class="card card-block" style="margin: 30px 0;">
            @include('advertisements.upgrade')
        </div>

        <h3>{{ count($notification->data) }} Jobs found on {{ date("F jS, Y", strtotime($notification->created_at)) }}</h3>
        <p>Searching for "{{ $notification->search->keyword }} in {{ $notification->search->location }}" across {{ count(config('jobboards')) }} job boards.</p>

        @include('notifications.components.share')

        @foreach($notification->data as $job)
            @include('notifications.components.job-listing', ['job' => $job])
        @endforeach

        <div>
            <a href="{{ Request::url() }}/download" class="mt-3 btn btn-block btn-outline-info btn-lg">
                Download Jobs
            </a>
        </div>
    </div>
</div>

@endsection
