@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.show', $item))

@section('title', 'Detalles ' . $item->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <table class="table table-borderless table-responsive">
            <tbody>
                <tr>
                    <th class="text-right">Nombre</th>
                    <td> {{ $item->name }} </td>
                </tr>
                <tr>
                    <th class="text-right">Estatus</th>
                    <td> {{ $item->estatus ? 'Activo' : 'Inactivo'}} </td>
                </tr>
                <tr>
                    <th class="text-right">Creado</th>
                    <td> {{ $item->created_at }} </td>
                </tr>
                <tr>
                    <th class="text-right">Actualizado</th>
                    <td> {{ $item->updated_at }} </td>
                </tr>
                <tr>
                    <th class="text-right">Tipo de usuario</th>
                    <td>
                        @foreach ($item->roles as $r)
                        {{ $r->name }}
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('secondary-content')

@include('usuarios.list')

@endsection