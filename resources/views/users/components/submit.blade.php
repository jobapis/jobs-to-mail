<div class="form-group">
    @if (session('user'))
    <input type="submit" value="Add Search" class="mt-3 form-control btn btn-success btn-lg"/>
    @else
    <input type="submit" value="Sign Up" class="mt-3 form-control btn btn-success btn-lg"/>
    @endif
    <small><a href="/terms">Terms/Privacy Policy</a></small>
</div>