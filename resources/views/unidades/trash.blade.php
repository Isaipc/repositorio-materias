@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('unidades.trash', $item))

@section('primary-title')
    <i class="bi bi-collection-fill"></i>
    {{ $item->nombre }}
@endsection

@section('primary-content')
    <input id="materiaId" type="hidden" name="materia_id" value="{{ $item->id }}">
    <table id="table" class="table table-hover table-responsive-md table-md mt-2">
        <thead>
            <th>Unidad</th>
            <th>Eliminado</th>
            <th></th>
        </thead>
    </table>
@endsection

@section('scripts')
    <script src="{{ asset('js/contenido-archived.js') }}"></script>
@endsection
