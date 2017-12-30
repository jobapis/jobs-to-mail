<div class="card">
    <div class="card-body">
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
        <p><strong>Source:</strong> {{ $job['source'] }}</p>
    </div>
</div>
