@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.trash'))

@section('primary-title', 'Alumnos eliminados')

@section('primary-content')
<table class="table table-hover datatable table-responsive-sm mt-2">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th class="d-none d-md-table-cell">Correo electronico</th>
            <th>Usuario</th>
            <th>Tipo de usuario</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($archived as $key=> $r_item)
        <tr class="data-row" id="rowItem{{ $r_item->id }}">
            <td>{{ ++$key}} </td>
            <td>
                <a href="{{ route('usuarios.show', $r_item->id) }} " class="btn btn-link" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Mostrar detalles">
                    <i class="bi bi-box-arrow-up-right"></i>
                </a>
                {{ $r_item->nombre }}
            </td>
            <td class="d-none d-md-table-cell">{{ is_null($r_item->email) ? '-' : $r_item->email }} </td>
            <td scope="row"> {{ $r_item->username }} </td>
            <td>
                @if(!count($r_item->roles) == 0)
                <ul>
                    @foreach($r_item->roles as $r)
                    {{ $r->name }}
                    @endforeach
                    </ol>
                    @endif
            </td>
            <td>
                @if ($r_item->estatus == 0)
                <a href="javascript: document.getElementById('restore-{{ $r_item->id }}').submit()"
                    class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Restaurar">
                    <i class="bi bi-upload"></i>
                </a>
                <form id="restore-{{ $r_item->id }}" action="{{ route('usuarios.restore', $r_item->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                </form>
                @else
                <a href="{{ route('usuarios.edit', $r_item->id) }} " class="btn btn-sm btn-primary"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-materia" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-id="{{ $r_item->id }}" data-name="{{ $r_item->nombre }}"
                    data-url="/usuarios" title="Eliminar">
                    <i class="bi bi-trash-fill"></i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('secondary-content')
@include('usuarios.list')
@endsection