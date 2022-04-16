@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.edit', $materia, $item))

@section('title', 'Editar archivo')

@section('content')

<form action="{{ route('archivos.update', $item) }} " method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nom" class="col-form-label">Nombre</label>
            <input id="nom" type="text" class="form-control" name="nombre" value="{{ $item->nombre }}" required
                autofocus>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="formFileSm" class="form-label">Archivo</label>
            <input class="form-control" name="file" id="formFileSm" type="file">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="est" class="col-form-label text-md-right">Estatus</label>
            <select name="estatus" id="est" class="form-control">
                <option value="1" @if ($item->estatus == 1) 'selected' @endif>Habilitado</option>
                <option value="2" @if ($item->estatus == 2) 'selected' @endif>Deshabilitado</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-md btn-primary">Guardar</button>
    <a href="{{ route('archivos.index', $materia) }} " class="btn btn-md btn-light">Cancelar</a>
</form>

@endsection

@section('secondary-content')
@include('archivos.list')
@endsection