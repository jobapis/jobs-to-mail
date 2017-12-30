<table style="{{ $style['body_action'] ?? '' }}" class="table" align="center" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <p style="{{ $style['paragraph'] ?? '' }};">
                Out of searches? Email us at <a href="mailto:{{ config('mail.from.address') }}?subject=Requesting more searches on JobsToMail" target="_blank" style="font-weight: bold;">{{ config('mail.from.address') }}</a> to request more than {{ config('app.max_searches') }}.
            </p>
            <a href="mailto:{{ config('mail.from.address') }}?subject=Requesting more searches on JobsToMail"
               style="{{ $fontFamily ?? '' }} {{ $style['button'] ?? '' }} {{ $style['button--green'] ?? '' }}"
               class="button btn btn-success btn-lg"
               target="_blank"
            >Request More</a>
        </td>
    </tr>
</table>