<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Titulacion') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="d-flex align-items-center bg-secondary">
    <div class="my-auto w-100 px-3">
        <div class="mx-auto card col-xl-3 col-lg-4 col-md-6 shadow-lg">
            <div class="card-body">
                @yield('content')
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('js/app.js') }}"></script>

</html>
