<div class="row mt-2">
@if ($search->latestNotification)
    <div class="col-sm-6">
        <a href="/notifications/{{ $search->latestNotification->id }}" class="download-link btn btn-success btn-block">View Latest</a>
    </div>
    <div class="col-sm-6">
@else
    <div class="col-sm-12">
@endif
        <a href="/searches/{{ $search->id }}/unsubscribe" class="card-link btn btn-danger btn-block">Unsubscribe</a></p>
    </div>
</div>