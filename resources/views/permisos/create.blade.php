@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('permisos.create'))

@section('title', 'Nuevo permiso')

@section('content')
<form action="{{ route('permisos.store') }}" method="POST">
    @csrf

    <div class="form-group row">
        <label for="nom" class="col-md-2 col-form-label text-md-right">Nombre</label>
        <div class="col-md-4">
            <input id="nom" type="text" class="form-control" name="name" maxlength="100" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="sec" class="col-md-2 col-form-label text-md-right">Roles</label>
        <div class="col-md-6">
            <select id="role" name="roles[]" class="selectpicker" data-size="10" multiple
                title="Seleccione uno o varios roles">
                @foreach ($roles as $r)
                <option value="{{ $r->id}}">{{ $r->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-md btn-primary">Guardar</button>
    <a href="{{ route('permisos.index') }} " class="btn btn-md btn-light">Cancelar</a>
</form>
@endsection

@section('secondary-content')
@include('permisos.list')
@endsection