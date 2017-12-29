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
            <div class="card card-block">
                <h4 class="card-title">
                    <a href="{{ $job['url'] }}" target="_blank">{{ $job['title'] }}</a>
                </h4>
                @if($job['datePosted'])
                    <p>Posted on {{ date("F jS, Y", strtotime($job['datePosted'])) }}</p>
                @endif
                @if($job['company'])
                    <p>
                        <strong>Company:</strong>
                        {{ $job['company'] }}
                        @if($job['industry'] == 'Staffing')
                            <span class="text-muted">(Professional Recruiter)</span>
                        @endif
                    </p>
                @endif
                <p><strong>Location:</strong> {{ $job['location'] }}</p>
            </div>
        @endforeach
        <p>
            <a href="{{ Request::url() }}/download">Download Jobs</a>
        </p>
    </div>
</div>

@endsection
