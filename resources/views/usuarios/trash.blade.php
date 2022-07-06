@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.trash'))

@section('primary-title')
    <i class="bi bi-person-x-fill"></i>
    {{ __('Alumnos eliminados') }}
@endsection

@section('primary-content')

    @datatable(['id' => 'table'])
    @slot('thead')
        <tr>
            <th>Nombre</th>
            <th>Correo electronico</th>
            <th>Usuario</th>
            <th></th>
        </tr>
    @endslot
    @enddatatable
@endsection

@section('scripts')
    <script src="{{ asset('js/alumnos-archived.js') }}"></script>
@endsection
