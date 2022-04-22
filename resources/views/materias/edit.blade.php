@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.edit', $item))

@section('primary-title',__('Editar materia'))

@section('primary-content')
<form action="{{ route('materias.update', $item) }} " method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nom" class="col-form-label text-md-right">Nombre</label>
            <input id="nom" type="text" class="form-control" name="nombre" maxlength="100" required
                value="{{ $item->nombre }}">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="form-check form-switch">
                <input class="form-check-input" name="estatus" type="checkbox" role="switch" id="est" @if (
                    $item->estatus == 1 ) checked @endif>
                <label class="form-check-label" for="est">Habilitado para los alumnos</label>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-md btn-primary">Guardar</button>
    <a href="{{ route('materias.index') }} " class="btn btn-md btn-light">Cancelar</a>
</form>
@endsection

@section('secondary-content')
@include('materias.list')
@endsection