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
        <form id="materiaForm" action="javascript:void(0)" method="POST">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar unidad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input id="materiaId" type="hidden" name="id" value="0">
                        <div class="mb-3">
                            <label for="nombre" class="form-label text-md-right">Nombre</label>
                            <input id="nombre" type="text" class="form-control" name="nombre" maxlength="100" required
                                value="{{ old('nombre') }}">
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
                            <input id="clave" type="text" class="form-control" name="clave" maxlength="100"
                                aria-label="Example text with button addon" value="{{ old('clave') }}"
                                aria-describedby="buttonRandomKey">
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

    @datatable(['id' => 'dtMateria'])
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
    <script>
        const materiaModalElement = document.getElementById('materiaModal');
        const confirmationModalElement = document.getElementById('confirmationModal');

        const materiaModal = new bootstrap.Modal(materiaModalElement, {
            keyboard: true
        });

        const confirmationModal = new bootstrap.Modal(confirmationModalElement, {
            keyboard: true
        });

        let materiasDtOverrideGlobals = {
            language: dtLanguageOptions,
            paginate: true,
            processing: true,
            responsive: {
                details: true
            },
            ajax: {
                url: '/materias-ajax',
                dataSrc: 'data',
            },
            columns: [{
                    data: null
                },
                {
                    data: null
                },
                {
                    data: 'clave'
                },
                {
                    data: null
                }
            ],
            columnDefs: [{
                    targets: 0,
                    render: function(data, type, row, meta) {
                        renderHTML =
                            `<a href="/materias/${data.id}" class="btn btn-link has-tooltip" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Mostrar detalles">
                                <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                        ${data.nombre}`
                        return renderHTML;
                    }
                },
                {
                    targets: 1,
                    render: function(data, type, row, meta) {
                        return `<div class="form-check form-switch">
                                    <input class="form-check-input change-status" ${data.estatus == 1 ? 'checked' : ''} type="checkbox" role="switch"
                                    data-row="${meta.row}"
                                    data-url="materias-ajax">
                                </div>`;
                    }
                },
                {
                    targets: 2,
                    render: (data, type, row, meta) => {
                        return `<span class="alert alert-primary px-2 py-0">${data}</span>`;

                    }
                },
                {
                    targets: -1,
                    render: function(data, type, row, meta) {
                        renderHTML = `<button class="btn btn-sm btn-primary edit-item has-tooltip" 
                                        data-row="${meta.row}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-item has-tooltip" 
                                        data-row="${meta.row}"
                                        data-bs-toggle="tooltip" data-url="materias-ajax" data-bs-placement="top" title="Eliminar">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                    <a href="/materias/${data.id}/contenido" class="btn btn-sm btn-light has-tooltip" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Mostrar contenido">
                                        <i class="bi bi-file-earmark-fill"></i> Contenido
                                    </a>
                                    <a href="/materias/${data.id}/alumnos" class="btn btn-sm btn-light has-tooltip" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Mostrar alumnos">
                                        <i class="bi bi-people-fill"></i> Alumnos
                                    </a>`;
                        return renderHTML;
                    }
                },
            ],

        };
        const dtMateria = $('#dtMateria').DataTable(materiasDtOverrideGlobals);

        $('#addMateria').on('click', function() {
            materiaModal.show();
            $('#materiaForm')[0].reset();
            $('#materiaId').val(0);
            $('#clave').val(generateRandomKey());
            materiaModalElement.querySelector('.modal-title').textContent = 'Agregar materia';
        });

        $('#materiaForm').on('submit', function(e) {
            var form = $('#materiaForm');
            var data = form.serialize();
            var id = $('#materiaId');

            if (id.val() == 0) {
                url = '/materias-ajax'
                type = 'POST';
            } else {
                url = `/materias-ajax/${id.val()}`
                type = 'PUT';
            }

            $.ajax({
                type: type,
                url: url,
                dataType: 'json',
                data: data,
                success: (data) => {
                    showToast(data.success, TOAST_SUCCESS_TYPE);
                    materiaModal.hide();
                    form[0].reset();
                    dtMateria.ajax.reload();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    showToast(jqXHR.responseJSON.message, TOAST_ERROR_TYPE);
                }
            });
        });

        $('#dtMateria').on('click', 'tbody .edit-item', function() {
            const data = dtMateria.row(this.dataset.row).data();
            materiaModal.show();

            $('#materiaId').val(data.id);
            $('#nombre').val(data.nombre);
            $('#estatus').prop('checked', getSwitchStatus(data.estatus));
            $('#clave').val(data.clave);

            materiaModalElement.querySelector('.modal-title').textContent = 'Editar materia';
        });

        $('#confirmationDeleteButton').on('click', function() {
            const ITEM_URL = this.dataset.url;
            const ITEM_TYPE = this.dataset.type;

            $.ajax({
                type: ITEM_TYPE,
                url: ITEM_URL,
                success: (data) => {
                    confirmationModal.hide();
                    showToast(data.success, TOAST_SUCCESS_TYPE);
                    dtMateria.ajax.reload();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
                }
            });

        });

        $('#dtMateria').on('click', 'tbody .delete-item', function() {

            const data = dtMateria.row(this.dataset.row).data();
            const ITEM_URL = this.dataset.url;

            var confirmationDeleteButton = document.getElementById('confirmationDeleteButton');

            confirmationModalElement.querySelector('.modal-title').textContent = 'Eliminar';
            confirmationModalElement.querySelector('.modal-body').innerHTML =
                `<div>
            <i class="bi bi-exclamation-diamond-fill" style="font-size: 2.5rem; color: orange;"></i>
        </div>
        ¿Desea eliminar <span class='text-danger'>${data.nombre}</span>?`;

            confirmationModal.show();

            confirmationDeleteButton.dataset.url = `/${ITEM_URL}/${data.id}/archive`;
            confirmationDeleteButton.dataset.type = 'DELETE'
        });

        $('#buttonRandomKey').on('click', function() {
            $('#clave').val(generateRandomKey());

        });

        $('#dtMateria tbody').on('change', '.change-status', function() {
            const data = dtMateria.row(this.dataset.row).data();
            const ITEM_URL = this.dataset.url;
            const ITEM_STATUS = this.checked;

            $.ajax({
                type: 'PUT',
                url: `/${ITEM_URL}/${data.id}/change-status`,
                dataType: 'json',
                data: {
                    id: data.id,
                    estatus: ITEM_STATUS
                },
                success: (data) => {
                    showToast(data.success, TOAST_SUCCESS_TYPE);
                    dtMateria.ajax.reload();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
                }
            });

        });
    </script>
@endsection
