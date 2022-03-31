@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('operadores.create'))

@section('title', 'Nuevo operador')

@section('content')

<form action="{{ route('operadores.store') }} " method="POST">
    @csrf
    <div class="row">
        <div class="form-group col-md-6">
            <label for="nom">Nombre</label>
            <input id="nom" type="text" class="form-control" name="nombre" maxlength="100" required autocomplete="name" autofocus>
        </div>
        <div class="form-group col-md-6">
            <label for="ape">Apellidos</label>
            <input id="ape" type="text" class="form-control" name="apellidos" maxlength="100" required autocomplete="name" autofocus>
        </div>
    </div>

    <h4> Datos de licencia </h4>
    <div class="row">
        <div class="form-group col-md-3">
            <label for="no_licencia">Número</label>
            <input type="text" class="form-control" name="no_licencia" maxlength="12" required autocomplete="name"
                autofocus>
        </div>
        <div class="form-group col-md-3">
            <label for="clas_licencia">Clase</label>
            <input type="text" class="form-control" name="clas_licencia" maxlength="12" required>
        </div>
        <div class="form-group col-md-3">
            <label for="venc_licencia">Vencimiento</label>
            <input type="date" name="venc_licencia" class="form-control"
                value="{{ Carbon\Carbon::today()->format('Y-m-d') }}">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label for="uni" class="">Usuario</label>
            <div>
                <select id="uni" name="user_id" class="selectpicker" data-live-search="true" required data-size="10"
                    data-none-results-text="No se encontró {0}" title="Seleccione la usuario" data-show-subtext="true">
                    @foreach (App\User::all() as $usuario)
                    <option value="{{ $usuario->id }}" data-subtext=" {{ $usuario->username }} ">{{ $usuario->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="com" class="col-md-12 col-form-label">Notas</label>
        <div class="col-md-8">
            <textarea name="notas" class="form-control" id="com" rows="4"></textarea>
        </div>
    </div>

    <button type="submit" class="btn btn-md btn-primary">Guardar</button>
    <a href="{{ route('operadores.index') }} " class="btn btn-md btn-light">Cancelar</a>
</form>
@endsection

@section('secondary-content')
@include('operadores.list')
@endsection