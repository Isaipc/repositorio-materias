@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.edit', $item))

@section('primary-title', 'Editar usuario')

@section('primary-content')
<form action="{{ route('usuarios.update', $item) }} " method="POST">
    @csrf
    @method('PUT')
    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">
            <i class="bi bi-asterisk text-danger required"></i>
            {{ __('Nombre') }}
        </label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ $item->nombre }}" required autocomplete="name" autofocus maxlength="100">

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="username" class="col-md-4 col-form-label text-md-right">
            <i class="bi bi-asterisk text-danger required"></i>
            {{ __('Usuario') }}
        </label>


        <div class="col-md-6">
            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                name="username" value="{{ $item->username }}" required autocomplete="username" autofocus maxlength="10">

            @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">
            <i class="bi bi-asterisk text-danger required"></i>
            {{ __('Correo electrónico') }}
        </label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ $item->email }}" autocomplete="email" maxlength="50">

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Guardar') }}
            </button>
            <a href="{{ route('usuarios.index') }} " class="btn btn-md btn-light">Cancelar</a>
        </div>
    </div>
</form>
@endsection

@section('secondary-content')
@include('usuarios.list')
@endsection