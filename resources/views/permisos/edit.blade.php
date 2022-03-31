@extends('layouts.dashboard')

{{-- @section('breadcrumbs', Breadcrumbs::render('permisos.edit', $item)) --}}

@section('title', 'Editar permiso')

@section('content')
<form action="{{ route('permisos.update', $item) }} " method="POST">
    @csrf
    @method('PUT')

    <div class="form-group row">
        <label for="nom" class="col-md-2 col-form-label text-md-right">Nombre</label>
        <div class="col-md-4">
            <input id="nom" type="text" class="form-control" name="name" maxlength="100" value="{{ $item->name}}"
                required>
        </div>
    </div>
    <div class="form-group row">
        <label for="sec" class="col-md-2 col-form-label text-md-right">Roles</label>
        <div class="col-md-6">
            <select id="role" name="roles[]" class="selectpicker" data-size="10" multiple
                title="Seleccione uno o varios roles">
                @foreach ($roles as $r)
                @if (in_array($r->name, $item->getRoleNames()->toArray(), true))
                <option value="{{ $r->id}}" selected>{{ $r->name }}</option>
                @else
                <option value="{{ $r->id}}">{{ $r->name }}</option>
                @endif
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