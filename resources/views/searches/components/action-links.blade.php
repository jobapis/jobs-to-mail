<div class="row">
@if (session('user.tier') === config('app.user_tiers.premium') && $search->latestNotification)
    <div class="col-sm-6">
        <a href="/collections/{{ $search->latestNotification->id }}/download" class="download-link btn btn-success btn-block">Download Latest Jobs</a>
    </div>
    <div class="col-sm-6">
@else
    <div class="col-sm-12">
@endif
        <a href="/searches/{{ $search->id }}/unsubscribe" class="card-link btn btn-danger btn-block">Unsubscribe</a></p>
    </div>
</div>