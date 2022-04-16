@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.show', $materia, $item))

@section('title')
<i class="bi bi-file-earmark-pdf-fill"></i>
{{ $item->nombre }}
@endsection

@section('content')
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
                    <th class="text-end">URL</th>
                    <td>
                        <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer">{{ $item->url }}</a>
                    </td>
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
@endsection

@section('secondary-content')
@include('archivos.list', $materia)
@endsection