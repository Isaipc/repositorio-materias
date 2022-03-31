@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('operadores.edit', $item))

@section('title', 'Editar operador')

@section('content')
<form action="{{ route('operadores.update', $item) }} " method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-6">
            <label for="">Nombre</label>
            <input type="text" class="form-control" name="nombre" maxlength="100" required value="{{ $item->nombre }}">
        </div>
        <div class="form-group col-md-6">
            <label for="">Apellidos</label>
            <input type="text" class="form-control" name="apellidos" maxlength="100" required value="{{ $item->apellidos }}">
        </div>
    </div>
    <h4> Datos de licencia </h4>
    <div class="row">
        <div class="form-group col-md-3">
            <label for="no_licencia">Número</label>
            <input type="text" class="form-control" name="no_licencia" maxlength="12" value="{{ $item->no_licencia }}"
                required autocomplete="name" autofocus>
        </div>
        <div class="form-group col-md-3">
            <label for="clas_licencia">Clase</label>
            <input type="text" class="form-control" name="clas_licencia" maxlength="12"
                value="{{ $item->clas_licencia }}" required>

        </div>
        <div class="form-group col-md-3">
            <label for="venc_licencia">Vencimiento</label>
            <input type="date" name="venc_licencia" class="form-control" required
                value="{{ Carbon\Carbon::parse($item->venc_licencia)->format('Y-m-d') }}">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label for="uni" class="">Usuario</label>
            <div>
                <select id="uni" name="user_id" class="selectpicker" data-live-search="true" required data-size="10"
                    data-none-results-text="No se encontró {0}" title="Seleccione la usuario" data-show-subtext="true">
                    @foreach (App\User::all() as $usuario)
                    @if($item->user && $item->user->id == $usuario->id)
                    <option value="{{ $usuario->id }}" data-subtext=" {{ $item->user->username }}" selected>
                        {{ $item->user->name }}
                    </option>
                    @else
                    <option value="{{ $usuario->id }}" data-subtext=" {{ $usuario->username }}">
                        {{ $usuario->name }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="com" class="col-md-12 col-form-label">Notas</label>
        <div class="col-md-8">
            <textarea name="notas" class="form-control" id="com" rows="4">{{ $item->notas }} </textarea>
        </div>
    </div>

    <button type="submit" class="btn btn-md btn-primary">Guardar</button>
    <a href="{{ route('operadores.index') }} " class="btn btn-md btn-light">Cancelar</a>
</form>

@endsection

@section('secondary-content')
@include('operadores.list')
@endsection