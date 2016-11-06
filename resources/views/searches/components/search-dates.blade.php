<p>Created: {{ date("F jS, Y", strtotime($search->created_at)) }}</p>

<p>Last sent:
@if ($search->latestNotification)
    {{ date("F jS, Y", strtotime($search->latestNotification->created_at)) }}
@else
    Never
@endif
</p>