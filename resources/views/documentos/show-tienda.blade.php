@extends('layouts.store')

@section('breadcrumbs', Breadcrumbs::render('tienda.producto', $producto))

@section('content')
<div class="row">

    <div class="col-md-6">
        <img src="{{ $producto->imageUrl() }}" alt="" width="500">
    </div>
    <table class="table table-stripped table-sm col-md-6">
        <tbody>
            <tr>
                <th>Nombre</th>
                <td> {{ $producto->nombre }} </td>
            </tr>
            <tr>
                <th>Categoria</th>
                <td> {{ $producto->categoria->nombre }} </td>
            </tr>
            <tr>
                <th>Precio menudeo</th>
                <td> $ {{ $producto->precio_menudeo }} </td>
            </tr>
            <tr>
                <th>Precio mayoreo</th>
                <td> $ {{ $producto->precio_mayoreo }} </td>
            </tr>
            <tr>
                <th>Stock</th>
                <td> {{ $producto->stock }} </td>
            </tr>
            <tr>
                <th>Detalles</th>
                <td> {{ $producto->detalles }} </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-4 float-right">
        @include('productos-en-carritos.add')
    </div>
</div>

@endsection