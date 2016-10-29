<!DOCTYPE html>
<html lang="en">
    @include('layouts.head')
    <body>
        @include('layouts.flash-messages')

        <div class="container-fluid">
            <nav class="navbar navbar-light bg-faded">
                <div class="nav navbar-nav">
                    <a class="nav-item nav-link" href="/">
                        <img src="/img/logo.png" width="24" height="24" alt="Home">
                    </a>
                    <a class="nav-item nav-link" href="/login">
                        Login
                    </a>
                </div>
            </nav>

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
