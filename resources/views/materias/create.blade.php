@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.create'))

@section('title', 'Nueva materia')

@section('content')
<form action="{{ route('materias.store') }} " method="POST" enctype="multipart/form-data">
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
            <label for="est" class="col-form-label text-md-right">Estatus</label>
            <select name="estatus" id="est" class="form-select">
                <option value="1">Habilitado</option>
                <option value="2">Deshabilitado</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-md btn-primary">Guardar</button>
    <a href="{{ route('materias.index') }} " class="btn btn-md btn-light">Cancelar</a>
</form>
@endsection

@section('secondary-content')
@include('materias.list')
@endsection