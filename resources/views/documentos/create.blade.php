@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.create'))

@section('title', 'Agregar archivo')

@section('content')

<form action="{{ route('archivos.store') }} " method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <div class="col-md-6">
            <label for="nom" class="col-form-label">Nombre</label>
            <input id="nom" type="text" class="form-control text-uppercase" name="nombre" value="{{ old('nombre') }}"
                required autofocus>
        </div>
    </div>
    <div class="form-group custom-file">
        <input type="file" name="image" class="custom-file-input" id="customFile">
        <label class="custom-file-label col-md-4" for="customFile">Elegir imagenes</label>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-md btn-primary">Guardar</button>
        <a href="{{ route('archivos.index') }} " class="btn btn-md btn-light">Cancelar</a>
    </div>
</form>
@endsection

@section('secondary-content')
@include('archivos.list')
@endsection