@if (session('user.tier') == config('app.user_tiers.premium'))
    <div class="form-check">
        <label class="form-check-label">
            <input name="no_recruiters" value="0" type="hidden">
            <input name="no_recruiters" value="1" type="checkbox" class="form-check-input">
            <span>Don't include posts by recruiters</span>
        </label>
    </div>
@else
<div class="form-check">
    <label class="form-check-label disabled"
           data-toggle="tooltip"
           data-html="true"
           data-placement="left"
           title="Enable this option by contacting <a href='mailto:upgrade@jobstomail.com' target='_blank'>upgrade@jobstomail.com</a>">
        <input name="no_recruiters" value="0" type="hidden">
        <input type="checkbox" class="form-check-input" disabled>
        <span class="">Don't include posts by recruiters</span>
    </label>
</div>
@endif