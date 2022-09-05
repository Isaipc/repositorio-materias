@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('unidades.index', $item))

@section('primary-title')
    <i class="bi bi-collection-fill"></i>
    {{ $item->nombre }}
    <span class="float-end">
        @hasrole('Administrador')
            <button class="btn btn-md btn-primary add-item" title="Crear nuevo" data-bs-toggle="modal"
                data-bs-target="#itemModal">
                <i class="bi bi-plus"></i>
            </button>
            <a href="{{ route('unidades.trash', $item) }}" class="btn btn-md btn-secondary position-relative"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar eliminados">
                <i class="bi bi-trash-fill"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $archived->count() }}
                    <span class="visually-hidden"></span>
                </span>
            </a>
        @endhasrole
        @hasrole('Alumno')
            <button id="detachMateria" class="btn btn-md btn-outline-danger" data-name="{{ $item->nombre }}">
                Darse de baja <i class="bi bi-x-lg ms-2"></i>
            </button>
        @endhasrole
    </span>

@endsection

@section('primary-content')
    <input id="materiaId" type="hidden" name="materia_id" value="{{ $item->id }}">

    @hasrole('Administrador')
        <!-- Save Modal -->
        <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <form id="unidadForm" action="javascript:void(0)" method="POST" class="needs-validation" novalidate>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Agregar unidad</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="materia_id" value="{{ $item->id }}">
                            <input id="unidadId" type="hidden" name="id" value="0">
                            <div class="mb-3">
                                <label for="unidadName" class="form-label text-md-right">Nombre</label>
                                <input id="unidadName" type="text" class="form-control" name="nombre" maxlength="100" required
                                    value="{{ old('nombre') }}">
                                <ul id="unidadNameInvalidFeedback" class="invalid-feedback"></ul>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input id="unidadStatus" class="form-check-input" name="estatus" type="checkbox"
                                        role="switch" id="est">
                                    <label class="form-check-label" for="estatus">Habilitado para los alumnos</label>
                                </div>
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

        <!-- File Upload Modal -->
        <div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="uploadFileForm" action="javascript:void(0)" method="POST" class="needs-validation" novalidate>
                        <div class="modal-header">
                            <h5 class="modal-title">Subir archivo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="error" class="alert alert-danger d-none"></div>
                            <input id="fileId" type="hidden" name="id" value="0">
                            <div class="mb-3">
                                <input class="form-control" name="file" id="file" type="file" required>
                                <ul id="fileInvalidFeedback" class="invalid-feedback"></ul>
                            </div>
                            <input id="unidadId" type="hidden" name="unidad_id" value="0">
                            <div class="mb-3">
                                <label for="fileName" class="col-form-label">Nombre</label>
                                <input id="fileName" type="text" class="form-control" name="nombre"
                                    value="{{ old('nombre') }}" autofocus required>
                                <ul id="fileNameInvalidFeedback" class="invalid-feedback"></ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-md btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <table id="table" data-materia="{{ $item->id }}" class="table table-hover table-responsive-md table-md mt-2">
            <thead>
                <th></th>
                <th>Unidad</th>
                <th>Habilitado</th>
                <th></th>
            </thead>
        </table>
    @endhasrole
    @hasrole('Alumno')
        <table id="table" data-materia="{{ $item->id }}" class="table table-hover table-responsive-md table-md mt-2">
            <thead>
                <th></th>
                <th>Unidad</th>
            </thead>
        </table>
    @endhasrole
@endsection

@section('scripts')
    @hasrole('Alumno')
        <script src="{{ asset('js/contenido-alumno.js') }}"></script>
    @endhasrole
    @hasrole('Administrador')
        <script src="{{ asset('js/contenido-admin.js') }}"></script>
    @endhasrole

@endsection
