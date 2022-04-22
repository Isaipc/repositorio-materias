@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.trash'))

@section('primary-title',__('Materias eliminadas'))

@section('primary-content')
<table class="table table-hover datatable table-responsive-sm mt-2">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($archived as $key=> $r_item)
        <tr class="data-row" id="rowItem{{ $r_item->id }}">
            <td>{{ ++$key}} </td>
            <td>
                <a href="{{ route('materias.show', $r_item->id) }} " class="btn btn-link" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Mostrar detalles">
                    <i class="bi bi-box-arrow-up-right"></i>
                </a>
                {{ $r_item->nombre }}
            </td>
            </td>
            <td>
                @if ($r_item->isArchived())
                <a href="javascript: document.getElementById('restore-{{ $r_item->id }}').submit()"
                    class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Restaurar">
                    <i class="bi bi-upload"></i>
                </a>
                <form id="restore-{{ $r_item->id }}" action="{{ route('materias.restore', $r_item->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('secondary-content')
@include('materias.list')
@endsection