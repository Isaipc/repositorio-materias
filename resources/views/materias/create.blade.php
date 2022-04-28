@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.create'))

@section('primary-title')
    <i class="bi bi-plus-square-fill"></i>
    {{ __('Nueva materia') }}
@endsection

@section('primary-content')
    <form id="materiaForm" action="javascript:void(0)" method="POST">
        @csrf
        <input id="itemId" type="hidden" name="id" value="0">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="nom" class="col-form-label text-md-right">Nombre</label>
                <input id="nom" type="text" class="form-control" name="nombre" maxlength="100" required
                    value="{{ old('nombre') }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" name="estatus" type="checkbox" role="switch" id="est">
                    <label class="form-check-label" for="est">Habilitado para los alumnos</label>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-md btn-primary">Guardar</button>
    </form>
@endsection

@section('secondary-content')
    @include('materias.list')
@endsection
