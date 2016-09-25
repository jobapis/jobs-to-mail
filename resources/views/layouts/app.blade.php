<!DOCTYPE html>
<html lang="en">
    @include('layouts.head')
    <body>
        @include('layouts.flash-messages')
        <div class="container-fluid">
            @yield('content')
        </div>
        @include('layouts.footer')
    </body>
</html>
