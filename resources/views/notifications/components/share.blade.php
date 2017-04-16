<p class="text-sm-center">
    <a class="btn btn-secondary" href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}">Share on Facebook</a>
    <a class="btn btn-secondary" href="https://twitter.com/home?status=Check%20out%20these%20jobs%20from%20JobsToMail%20{{ Request::url() }}">Share on Twitter</a>
    <a class="btn btn-secondary" href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}&title=Check%20out%20these%20job%20listings%20on%20JobsToMail&summary={{ count($notification->data) }} Jobs found on {{ date("F jS, Y", strtotime($notification->created_at)) }}&source=">Share on LinkedIn</a>
</p>
