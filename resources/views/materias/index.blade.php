@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.index'))

@section('primary-title')
    <i class="bi bi-collection-fill"></i>
    {{ __('Materias') }}
    <span class="float-end">
        <button id="addMateria" class="btn btn-md btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
            title="Crear nuevo">
            <i class="bi bi-plus"></i>
        </button>
        <a href="{{ route('materias.trash') }}" class="btn btn-md btn-secondary position-relative" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Mostrar eliminados">
            <i class="bi bi-trash-fill"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $archived->count() }}
                <span class="visually-hidden"></span>
            </span>
        </a>
    </span>
@endsection

@section('primary-content')
    <!-- Save Modal -->
    <div class="modal fade" id="materiaModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <form id="materiaForm" action="javascript:void(0)" method="POST" class="needs-validation" novalidate>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar unidad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="error" class="alert alert-danger d-none"></div>
                        <input id="materiaId" type="hidden" name="id" value="0">
                        <div class="mb-3">
                            <label for="nombre" class="form-label text-md-right">Nombre</label>
                            <input id="nombre" type="text" class="form-control" name="nombre" maxlength="60" required>
                            <ul id="nombreInvalidFeedback" class="invalid-feedback"></ul>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input id="estatus" class="form-check-input" name="estatus" type="checkbox" role="switch"
                                    id="est">
                                <label class="form-check-label" for="estatus">Habilitado para los alumnos</label>
                            </div>
                        </div>
                        <label for="clave" class="form-label text-md-right">Clave</label>
                        <div class="input-group mb-3">
                            <input id="clave" type="text" class="form-control" name="clave" maxlength="10"
                                aria-label="Example text with button addon" aria-describedby="buttonRandomKey" required>
                            <ul id="claveInvalidFeedback" class="invalid-feedback"></ul>
                            <button class="btn btn-outline-secondary" type="button" id="buttonRandomKey">Generar
                                clave</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-md btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @datatable(['id' => 'table'])
    @slot('thead')
        <tr>
            <th>Materia</th>
            <th>Habilitado</th>
            <th>Clave de acceso</th>
            <th></th>
        </tr>
    @endslot
    @enddatatable
@endsection

@section('scripts')
    <script src="{{ asset('js/materias.js') }}"></script>
@endsection
