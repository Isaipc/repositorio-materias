@extends('layouts.guest')

@section('content')
    <div class="row justify-content-center">

        <h4 class="text-center mb-4">Restrablecer contraseña</h4>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="col-form-label text-md-right">{{ __('Correo electrónico') }}</label>

                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">
                    {{ __('Enviar enlace') }}
                </button>
                <a href="{{ route('login') }}" class="btn btn-link">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
