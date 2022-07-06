@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.trash'))

@section('primary-title')
    <i class="bi bi-trash-fill"></i>
    {{ __('Materias eliminadas') }}
@endsection

@section('primary-content')
    @datatable(['id' => 'table'])
    @slot('thead')
        <tr>
            <th>Materia</th>
            <th></th>
        </tr>
    @endslot
    @enddatatable
@endsection

@section('scripts')
    <script src="{{ asset('js/materias-archived.js') }}"></script>
@endsection
