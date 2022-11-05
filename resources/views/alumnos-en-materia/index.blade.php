@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('alumnos.index', $item))

@section('primary-title')
    <i class="bi bi-people-fill"></i>
    {{ __('Alumnos en ') }} {{ $item->nombre}}
@endsection

@section('primary-content')
    <input id="materiaId" type="hidden" name="materia_id" value="{{ $item->id }}">
    @datatable(['id' => 'table'])
    @slot('thead')
        <tr>
            <th>Alumno</th>
            <th>Correo</th>
            <th>Registrado</th>
        </tr>
    @endslot
    @enddatatable
@endsection

@section('scripts')
    <script src="{{ asset('js/alumnos-en-materia.js')}}"></script>
@endsection
