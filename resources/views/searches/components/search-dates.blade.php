<p><strong>Created:</strong> {{ date("F jS, Y", strtotime($search->created_at)) }}</p>

<p><strong>Last sent:</strong>
@if ($search->latestNotification)
    {{ date("F jS, Y", strtotime($search->latestNotification->created_at)) }}
@else
    Never
@endif
</p>