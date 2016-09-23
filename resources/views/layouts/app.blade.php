<html>
    <head>
        <title>{{ config('app.name') }} | @yield('title')</title>
    </head>
    <body>
        @include('layouts.flash-messages')
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
