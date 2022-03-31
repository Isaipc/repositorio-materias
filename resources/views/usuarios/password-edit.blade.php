@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.password-edit', $item))

@section('title', 'Restablecer contraseña')

@section('content')
<form method="POST" action="{{ route('usuarios.password-reset', $item) }}">
    @csrf
    @method('PUT')

    {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}

    <div class="form-group row">
        <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Contraseña') }}</label>

        <div class="col-md-4">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password-confirm"
            class="col-md-2 col-form-label text-md-right">{{ __('Confirmar contraseña') }}</label>

        <div class="col-md-4">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password">
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-2">
            <button type="submit" class="btn btn-primary">
                {{ __('Restablecer contraseña') }}
            </button>
        </div>
    </div>
</form>

@include('usuarios.list')
@endsection