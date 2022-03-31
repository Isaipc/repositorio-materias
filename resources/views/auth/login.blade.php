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

<body class="d-flex align-items-center">
    <div class="my-auto w-100">
        <div class="mx-auto card col-md-4">
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                    <div class="row justify-content-center">
                        <img src="{{ asset('img/isc.jpg') }}" width="200px" alt="" srcset="">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="username" class="col-md-8 col-lg-6 col-form-label mx-auto">
                                {{ __('Usuario') }}
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-lg-6 mx-auto">
                                <input id="username" type="text" class="form-control 
                        @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required
                                    autofocus maxlength="50">

                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label for="password" class="col-md-8 col-lg-6 col-form-label mx-auto">
                                {{ __('Contraseña') }}
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-lg-6 mx-auto">
                                <input id="password" type="password" class="form-control 
                        @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password" maxlength="15">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 d-flex flex-column mx-auto">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Iniciar sesión') }}
                            </button>

                            {{-- @if (Route::has('password.request')) <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Olvidé mi contraseña') }} </a> @endif --}}

                            <a href="{{ route('register') }}" class="btn btn-link">
                                {{ __('Crear cuenta') }} </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('js/app.js') }}"></script>

</html>