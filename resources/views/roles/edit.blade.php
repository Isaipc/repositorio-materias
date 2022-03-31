@extends('layouts.dashboard')

@section('title', 'Editar rol')

@section('content')
<form action="{{ route('roles.update', $item) }} " method="POST">
    @csrf
    @method('PUT')
    <div class="form-group row">
        <label for="nom" class="col-md-2 col-form-label text-md-right">Nombre</label>
        <div class="col-md-4">
            <input id="nom" type="text" class="form-control" name="name" maxlength="100" required
                value="{{ $item->name }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="per" class="col-form-label col-md-12">Permisos</label>
        <div class="col-md-6">
            <select id="per" name="permisos[]" class="selectpicker" data-live-search="true" data-size="10" multiple
                data-actions-box="true" data-select-all-text="Todos" data-deselect-all-text="Ninguno"
                data-none-results-text="No se encontró {0}" title="Seleccione uno o varios">
                @foreach ($permisos as $_i)
                @if (in_array($_i->name, $item->permissions->pluck('name')->toArray(), true))
                <option value="{{ $_i->id }}" selected>{{ $_i->name}}</option>
                @else
                <option value="{{ $_i->id }}">{{ $_i->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-md btn-primary">Guardar</button>
    <a href="{{ route('roles.index') }} " class="btn btn-md btn-light">Cancelar</a>
</form>
@endsection

@section('secondary-content')
@include('roles.list')
@endsection