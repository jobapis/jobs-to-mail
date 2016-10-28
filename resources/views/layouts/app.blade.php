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
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/tether.min.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/js/app.js"></script>
    </body>
</html>
