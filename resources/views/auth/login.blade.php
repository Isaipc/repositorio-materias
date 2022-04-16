@extends('layouts.guest')

@section('content')
<form method="POST" action="{{ route('login') }}" autocomplete="off">
    @csrf
    <div class="">
        <img src="{{ asset('img/isc-2.svg') }}" width="200px" class="img-fluid mx-auto d-block" alt="" srcset="">
    </div>
    <div class="mb-3">
        <label for="username" class="">
            {{ __('Usuario') }}
        </label>
        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username"
            value="{{ old('username') }}" required autofocus>

        @error('username')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="">
            {{ __('Contraseña') }}
        </label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" required autocomplete="current-password">
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="mb-3">
        <div class="col-xl-9 col-lg-12 d-flex flex-column mx-auto">
            <button type="submit" class="btn btn-primary">
                {{ __('Iniciar sesión') }}
            </button>

            @if (Route::has('password.request')) <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Olvidé mi contraseña') }} </a> @endif

            <a href="{{ route('register') }}" class="btn btn-link">
                {{ __('Crear cuenta de alumno') }} </a>
        </div>
    </div>
</form>
@endsection