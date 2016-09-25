@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))
        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
    @endif
@endforeach
@foreach ($errors->all() as $message)
    <p class="alert alert-danger">{{ $message }}</p>
@endforeach
