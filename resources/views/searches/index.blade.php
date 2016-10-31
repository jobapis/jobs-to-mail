@extends('layouts.app')

@section('title', config('app.description'))

@section('content')

@include('layouts.sitetitle')

<div class="row searches">
    <div class="col-lg-8 offset-lg-2 col-sm-12 offset-sm-0">
        <h3>Your Searches</h3>
        @foreach($searches as $search)
            <div class="card card-block">
                <h4 class="card-title">"{{ $search->keyword }}"</h4>
                <p>Location: "{{ $search->location }}"</p>
                <div class="form-check">
                    <label class="form-check-label disabled"
                           data-toggle="tooltip"
                           data-html="true"
                           data-placement="left"
                           title="Enable this option by contacting <a href='mailto:upgrade@jobstomail.com' target='_blank'>upgrade@jobstomail.com</a>">
                        <input type="checkbox"
                               class="form-check-input"
                               {{ $search->no_recruiters ? 'checked' : '' }}
                               disabled
                               readonly>
                        <span class="">Don't include posts by recruiters</span>
                    </label>
                </div>
                <p><a href="/searches/{{ $search->id }}/unsubscribe" class="card-link">Unsubscribe</a></p>
            </div>
        @endforeach
        <div><a href="/" class="btn btn-block btn-outline-success btn-lg">Create a New Search</a></div>
    </div>
</div>

@endsection
