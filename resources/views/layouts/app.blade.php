<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>{{ config('app.name') }} | @yield('title')</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
        <link rel="icon" href="./favicon.ico" type="image/x-icon">
        <!-- Stylesheet -->
        <link href="./css/app.css" rel="stylesheet">

    </head>
    <body>
        @include('layouts.flash-messages')
        <div class="container-fluid">
            @yield('content')
        </div>
        @include('layouts.footer')
    </body>
</html>
