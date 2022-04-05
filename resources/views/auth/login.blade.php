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
    <div class="my-auto w-100">
        <div class="mx-auto card col-xl-3 col-lg-4 col-md-6 shadow-lg">
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                    <div class="row justify-content-center">
                        <img src="{{ asset('img/isc.jpg') }}" width="200px" alt="" srcset="">
                    </div>
                    <div class="form-group">
                        <label for="username" class="">
                            {{ __('Usuario') }}
                        </label>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                            name="username" value="{{ old('username') }}" required autofocus>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="">
                            {{ __('Contraseña') }}
                        </label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-xl-9 col-lg-12 d-flex flex-column mx-auto">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Iniciar sesión') }}
                            </button>

                            @if (Route::has('password.request')) <a class="btn btn-link"
                                href="{{ route('password.request') }}">
                                {{ __('Olvidé mi contraseña') }} </a> @endif

                            <a href="{{ route('register') }}" class="btn btn-link">
                                {{ __('Crear cuenta de alumno') }} </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('js/app.js') }}"></script>

</html>