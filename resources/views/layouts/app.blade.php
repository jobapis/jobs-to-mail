<!DOCTYPE html>
<html lang="en">
    @include('layouts.head')
    <body>
        @include('layouts.flash-messages')

        <div class="container-fluid">

            <div class="main">
                @yield('content')
            </div>

        </div>

        @include('layouts.footer')

    </body>
</html>
