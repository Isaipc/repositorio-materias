@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.create'))

@section('primary-title',__('Nueva materia'))
@section('primary-content')
<form action="{{ route('materias.store') }} " method="POST">
    @csrf
    <div class="form-group row">
        <div class="col-md-4">
            <label for="nom" class="col-form-label text-md-right">Nombre</label>
            <input id="nom" type="text" class="form-control" name="nombre" maxlength="100" required
                value="{{ old('nombre') }}">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4">
            <div class="form-check form-switch">
                <input class="form-check-input" name="estatus" type="checkbox" role="switch" id="est">
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