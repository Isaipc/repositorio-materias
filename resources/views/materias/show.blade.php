@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.show', $item))

@section('title', $item->nombre)

@section('content')

@hasrole('Administrador')
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
@endhasrole

@endsection
@section('secondary-content')
<div class="card mt-2">
    <div class="card-body container shadow-sm">

        <h5> Archivos</h5>

        @hasrole('Administrador')
        <a href="{{ route('archivos.index', $item->id) }} " class="btn btn-sm btn-primary">
            <i class="bi bi-plus"></i> Agregar
        </a>
        @endhasrole

        <div class="row">
            <div class="col-md-8">
                @if ($item->archivos->count() == 0)
                <p class="text-muted">
                    No hay archivos
                </p>
                @else

                <ul class="list-group list-group-flush">
                    @foreach ($item->archivos as $file)
                    <a href="{{ $file->url }}"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-file-earmark-fill"></i>
                            {{ $file->nombre }}
                        </span>
                        <span>
                            {{ $file->url }}
                        </span>
                    </a>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</div>


@hasrole('Administrador')
<div class="card mt-2">
    <div class="card-body container shadow-sm">
        <h5> Alumnos </h5>
        <div class="row">
            <div class="col-md-8">
                @if ($item->alumnos()->count() == 0)
                <p class="text-muted">
                    No hay alumnos
                </p>
                @else
                <ul class="list-group list-group-flush">
                    @foreach ($item->alumnos as $a)
                    <a href="{{ route('usuarios.show', $a) }}"
                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span>
                            <i class="bi bi-person-fill"></i>
                            {{ $a->name }}
                        </span>
                    </a>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</div>


@include('materias.list')
@endhasrole
@endsection