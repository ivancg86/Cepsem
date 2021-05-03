<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>cepsem | @yield('pagename')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/logos/cepsem-simple.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>

    <div id="app">
        @yield('header')
        @yield('content')
    </div>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbznB2qSiIQAIUmm4SwaIeFSYXaBe2dqg&libraries=&v=weekly" async></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>
    <script src="{{ asset('js/formacio.js') }}"></script>
</body>

</html>
