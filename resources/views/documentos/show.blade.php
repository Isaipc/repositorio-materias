@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.show', $item))

@section('title', 'Detalles de producto: ' . $item->nombre)

@section('content')
<table class="table table-striped table-sm">
    <tbody>
        <tr>
            <th>Nombre</th>
            <td> {{ $item->nombre }} </td>
        </tr>
        <tr>
            <th>Categoria</th>
            <td>
                <a href="{{ route('materias.show', $item->categoria->id) }}">
                    {{ $item->categoria->nombre }}
                </a>
            </td>
        </tr>
        <tr>
            <th>Estatus</th>
            <td> {{ $item->estatus ? 'Activo' : 'Inactivo'}} </td>
        </tr>
        <tr>
            <th>Precio menudeo</th>
            <td> $ {{ $item->precio_menudeo }} </td>
        </tr>
        <tr>
            <th>Precio mayoreo</th>
            <td> $ {{ $item->precio_mayoreo }} </td>
        </tr>
        <tr>
            <th>Stock</th>
            <td> {{ $item->stock }} </td>
        </tr>
        <tr>
            <th>Detalles</th>
            <td> {{ $item->detalles }} </td>
        </tr>
         <tr>
            <th>Fecha de creación</th>
            <td> {{ $item->created_at }} </td>
        </tr>
        <tr>
            <th>Fecha de ultima actualización</th>
            <td> {{ $item->updated_at }} </td>
        </tr>
    </tbody>
</table>

<label for="">Fotos</label>
<div class="form-group row">
    <div class="col-md-4">
        @if ($item->images->count() == 0)
        <img src="{{  asset('img/no-disponible.svg') }}" width="200px" alt="">
        @else
        <a href="{{ $item->images->first()->url }}">
            <img src="{{ $item->images->first()->url }}" width="200px" class="img-thumbnail" alt="">
        </a>
        @endif
    </div>
</div>
@endsection