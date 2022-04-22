@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.show', $item))

@section('primary-title', $item->nombre)

@section('primary-content')
<div class="row">
    <div class="col-md-8">
        <table class="table table-borderless table-responsive">
            <tbody>
                <tr>
                    <th class="text-end">Nombre</th>
                    <td> {{ $item->nombre }} </td>
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
                <tr>
                    <th class="text-end">Tipo de usuario</th>
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