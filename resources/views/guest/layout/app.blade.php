<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Shop') }}</title>
    
    <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/guest/animate.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/guest/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/guest/owl.theme.default.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/guest/custom.css') }}">

    <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('guest.parts.nav')
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12" id="divContainer">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
