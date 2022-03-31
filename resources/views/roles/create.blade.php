@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('roles.create'))

@section('title', 'Nuevo rol')

@section('content')
<form action="{{ route('roles.store') }} " method="POST">
    @csrf
    <div class="form-group row">
        <label for="nom" class="col-md-2 col-form-label text-md-right">Nombre</label>
        <div class="col-md-4">
            <input id="nom" type="text" class="form-control" name="name" maxlength="100" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="per" class="col-form-label col-md-12">Permisos</label>
        <div class="col-md-6">
            <select id="per" name="permisos[]" class="selectpicker" data-live-search="true" data-size="10" multiple
                data-actions-box="true" data-select-all-text="Todos" data-deselect-all-text="Ninguno"
                data-none-results-text="No se encontró {0}" title="Seleccione uno o varios">
                @foreach ($permisos as $_i)
                <option value="{{ $_i->id }}">{{ $_i->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <a href="{{ route('roles.index') }} " class="btn btn-md btn-light">Cancelar</a>
</form>
@endsection

@section('secondary-content')
@include('roles.list')
@endsection