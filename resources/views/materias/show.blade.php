@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.show', $item))

@section('primary-title', $item->nombre)

@section('primary-content')

@hasrole('Administrador')
<div class="row">
    <div class="col-md-6">
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <th class="text-end">Nombre</th>
                    <td> {{ $item->nombre}} </td>
                </tr>
                <tr>
                    <th class="text-end">Estatus</th>
                    <td> {{ $item->getEstatusName() }} </td>
                </tr>
                <tr>
                    <th class="text-end">Creado</th>
                    <td> {{ $item->created_at }} </td>
                </tr>
                <tr>
                    <th class="text-end">Actualizado</th>
                    <td> {{ $item->updated_at }} </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endhasrole
@endsection


@section('secondary-content')
@include('materias.list')
@endsection