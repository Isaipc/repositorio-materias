@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.create', $materia))

@section('title', 'Agregar archivo')

@section('content')

<form action="{{ route('archivos.store', $materia) }} " method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <div class="col-md-4">
            <label for="nom" class="col-form-label">Nombre</label>
            <input id="nom" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required
                autofocus>
        </div>
    </div>
    <div class="form-group custom-file">
        <input type="file" name="file" class="custom-file-input" id="customFile">
        <label class="custom-file-label col-md-4" for="customFile">Elegir archivo</label>
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

    <div class="form-group">
        <button type="submit" class="btn btn-md btn-primary">Guardar</button>
        <a href="{{ route('archivos.index', $materia) }} " class="btn btn-md btn-light">Cancelar</a>
    </div>
</form>
@endsection

@section('secondary-content')
@include('archivos.list')
@endsection