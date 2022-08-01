@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.trash', $parent, $item))

@section('primary-title')
    <i class="bi bi-collection-fill"></i>
    {{ $item->nombre }}
@endsection

@section('primary-content')
    <input id="unidadId" type="hidden" name="unidad_id" value="{{ $item->id }}">
    <table id="table" class="table table-hover table-responsive-md table-md mt-2">
        <thead>
            <th>Archivo</th>
            <th>Eliminado</th>
            <th></th>
        </thead>
    </table>
@endsection

@section('scripts')
    <script src="{{ asset('js/archivos-archived.js') }}"></script>
@endsection
