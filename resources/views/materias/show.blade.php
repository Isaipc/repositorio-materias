@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.show', $item))

@section('title', $item->nombre)

@section('content')
<table class="table">
    <tbody>
        <tr>
            <th>Nombre</th>
            <td> {{ $item->nombre}} </td>
        </tr>
        <tr>
            <th>Estatus</th>
            <td> {{ $item->getEstatusName() }} </td>
        </tr>
        <tr>
            <th>Fecha de creación</th>
            <td> {{ $item->created_at }} </td>
        </tr>
        <tr>
            <th>Fecha de ultima actualización</th>
            <td> {{ $item->updated_at }} </td>
        </tr>
    </tbody>
</table>

<hr>
<label for="">Archivos</label>
<div class="form-group row">
    <div class="col-md-8">
        @if ($item->documentos->count() == 0)
        <p class="text-muted">
            No hay archivos
        </p>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Url</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($item->documentos as $doc)
                <tr>
                    <td>{{ $doc->nombre }} </td>
                    <td>{{ $doc->url }} </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@endsection

@section('secondary-content')
@include('materias.list')
@endsection