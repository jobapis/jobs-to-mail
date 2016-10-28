@extends('layouts.app')

@section('title', config('app.description'))

@section('content')
    <div class="row searches">
        <div class="col-sm-8 offset-sm-2">
            <h1>Your Searches</h1>
            @foreach($searches as $search)
                <div class="card card-block">
                    <h4 class="card-title">"{{ $search->keyword }}"</h4>
                    <p>Location: "{{ $search->location }}"</p>
                    <div class="form-check">
                        <label class="form-check-label disabled"
                               data-toggle="tooltip"
                               data-html="true"
                               data-placement="left"
                               title="Enable this option by contacting <a href='mailto:beta@jobstomail.com' target='_blank'>upgrade@jobstomail.com</a>">
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
            <p><a href="/">Back to Homepage</a></p>
        </div>
    </div>
@endsection
