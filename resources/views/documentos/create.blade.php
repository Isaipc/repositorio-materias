@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('documentos.create'))

@section('title', 'Nuevo archivo')

@section('content')

<form action="{{ route('documentos.store') }} " method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <div class="col-md-6">
            <label for="nom" class="col-form-label">Nombre</label>
            <input id="nom" type="text" class="form-control text-uppercase" name="nombre" value="{{ old('nombre') }}"
                required autofocus>
        </div>
    </div>
    <div class="form-group row">
        <label for="cat" class="col-form-label col-md-12">Categoria</label>
        <div class="col-md-6">
            <select id="cat" name="categoria" class="selectpicker" data-live-search="true" data-size="10"
                title="Seleccione una categoria" required>
                @foreach ($categorias as $c)
                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4">
            <label for="pre_me" class="col-form-label">Precio menudeo</label>
            <input id="pre_me" type="number" min="0" class="form-control" name="precio_menudeo" required
                value="{{ old('precio_menudeo') }}">
        </div>
        <div class="col-md-4">
            <label for="pre_ma" class="col-form-label">Precio mayoreo</label>
            <input id="pre_ma" type="number" min="0" class="form-control" name="precio_mayoreo" required
                value="{{ old('precio_mayoreo') }}">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4">
            <label for="stock">Stock</label>
            <input id="stock" type="number" min="0" class="form-control" name="stock" required
                value="{{ old( 'stock')}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="com" class="col-md-12 col-form-label">Detalles</label>
        <div class="col-md-8">
            <textarea name="detalles" class="form-control" id="com" rows="4" required>{{ old('detalles') }}</textarea>
        </div>
    </div>
    <div class="form-group custom-file">
        <input type="file" name="image" class="custom-file-input" id="customFile">
        <label class="custom-file-label col-md-4" for="customFile">Elegir imagenes</label>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-md btn-primary">Guardar</button>
        <a href="{{ route('documentos.index') }} " class="btn btn-md btn-light">Cancelar</a>
    </div>
</form>

@endsection

@section('secondary-content')
@include('documentos.list')
@endsection