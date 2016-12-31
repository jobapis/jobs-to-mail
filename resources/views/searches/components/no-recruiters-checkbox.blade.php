<div class="form-check">
    <label class="form-check-label disabled">
        <input type="checkbox"
               class="form-check-input"
               {{ $search->no_recruiters ? 'checked' : '' }}
               disabled
               readonly>
        <span class="">Don't include posts by recruiters</span>
    </label>
</div>