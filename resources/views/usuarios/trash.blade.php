@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.trash'))

@section('primary-title')
    <i class="bi bi-person-x-fill"></i>
    {{ __('Usuarios eliminados') }}
@endsection

@section('primary-content')

    @datatable(['id' => 'usuariosTrashDT'])
    @slot('thead')
        <tr>
            <th>Nombre</th>
            <th class="d-none d-md-table-cell">Correo electronico</th>
            <th>Usuario</th>
            <th></th>
        </tr>
    @endslot
    @enddatatable
@endsection

@section('secondary-content')
    @include('usuarios.list')
@endsection
