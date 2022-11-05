@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('alumnos.index', $item))

@section('primary-title')
    <i class="bi bi-people-fill"></i>
    {{ __('Alumnos en ') }} {{ $item->nombre }}
    <span class="float-end">
        <button id="closeCourse" class="btn btn-md btn-outline-danger" data-id="{{ $item->id }}"
            data-name="{{ $item->nombre }}">
            Cerrar curso
            <i class="bi bi-exclamation-circle"></i>
        </button>
    </span>
@endsection

@section('primary-content')
    <input id="materiaId" type="hidden" name="materia_id" value="{{ $item->id }}">
    @datatable(['id' => 'table'])
    @slot('thead')
        <tr>
            <th>Alumno</th>
            <th>Correo</th>
            <th>Registrado</th>
            <th>Acciones</th>
        </tr>
    @endslot
    @enddatatable
@endsection

@section('scripts')
    <script src="{{ asset('js/alumnos-en-materia.js') }}"></script>
@endsection
