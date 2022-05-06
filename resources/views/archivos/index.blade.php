@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.index', $item))

@section('primary-title')
    <i class="bi bi-collection-fill"></i>
    {{ $item->nombre }}
    <span class="float-end">
        @hasrole('Administrador')
            <button class="btn btn-md btn-primary add-item" title="Crear nuevo" data-bs-toggle="modal"
                data-bs-target="#itemModal">
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
        @endhasrole
        @hasrole('Alumno')
            <button id="detachMateria" class="btn btn-md btn-outline-danger" data-url="alumnos/materias">
                Darse de baja
                <i class="bi bi-x-lg ms-2"></i>
            </button>
        @endhasrole
    </span>

@endsection

@section('primary-content')
    @hasrole('Administrador')
        <!-- Save Modal -->
        <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <form id="unidadForm" action="javascript:void(0)" method="POST">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Agregar unidad</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="materia_id" value="{{ $item->id }}">
                            <input id="id" type="hidden" name="id" value="0">
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
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-md btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button id="confirmationDeleteButton" type="button" class="btn btn-primary">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- File Upload Modal -->
        <div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="fileUploadForm" action="javascript:void(0)" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title">Subir archivo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <input class="form-control" name="file" id="fileInput" type="file">
                            </div>
                            <input id="unidadId" type="hidden" name="unidad_id" value="0">
                            <div class="mb-3">
                                <label for="fileName" class="col-form-label">Nombre</label>
                                <input id="fileName" type="text" class="form-control" name="nombre"
                                    value="{{ old('nombre') }}" autofocus>
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

        <table id="dtContenido" data-materia="{{ $item->id }}" class="table table-hover table-responsive-md table-md mt-2">
            <thead>
                <th></th>
                <th>Unidad</th>
                <th>Habilitado</th>
                <th></th>
            </thead>
        </table>
    @endhasrole
    @hasrole('Alumno')
        <table id="dtContenidoAlumno" data-materia="{{ $item->id }}"
            class="table table-hover table-responsive-md table-md mt-2">
            <thead>
                <th></th>
                <th>Unidad</th>
            </thead>
        </table>
    @endhasrole
@endsection

@section('secondary-content')
    @include('materias.list')
@endsection

@section('scripts')

    @hasrole('Alumno')
        <script>
            var dtContenidoAlumno = $('#dtContenidoAlumno').DataTable({
                language: dtLanguageOptions,
                paginate: true,
                ajax: {
                    url: `/unidades/{{ $item->id }}/list`,
                    dataSrc: 'data',
                },
                columns: [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: ``
                    },
                    {
                        data: 'nombre'
                    },
                ]
            });

            var confirmationModalElement = document.getElementById('confirmationModal');

            var confirmationModal = new bootstrap.Modal(confirmationModalElement, {
                keyboard: true
            });

            $('#detachMateria').on('click', function() {
                const ITEM_URL = this.dataset.url;

                var confirmationDeleteButton = document.getElementById('confirmationDeleteButton');

                confirmationModalElement.querySelector('.modal-title').textContent = 'Dar de baja';
                confirmationModalElement.querySelector('.modal-body').innerHTML =
                    `<div>
                    <i class="bi bi-exclamation-circle-fill" style="font-size: 2.5rem; color: red;"></i>
                </div>
                ¿Desea darse de baja en <span class='text-danger'>{{ $item->nombre }}</span>?`;

                confirmationModal.show();

                confirmationDeleteButton.dataset.url = `/${ITEM_URL}/{{ $item->id }}`;
                confirmationDeleteButton.dataset.type = 'DELETE'
            });

            $('#dtContenidoAlumno').on('requestChild.dt', function(e, row) {
                var data = row.data();
                row.child(format(data)).show();
            });

            $('#dtContenidoAlumno').on('click', 'tbody td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = dtContenidoAlumno.row(tr);

                if (row.child.isShown())
                    row.child.hide();
                else {
                    row.child(format(row.data())).show();
                }
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
                        setTimeout(function() {
                            window.location.href = "/";
                        }, 5000);
                    },
                    error: (jqXHR, textStatus, errorThrown) => {
                        showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
                    }
                });
            });

            function format(data) {
                var rowItems = '';
                if (data.archivos.length == 0)
                    return `<span class="text-muted">No hay archivos disponibles</span>`

                data.archivos.forEach(e => {
                    rowItems += `<tr class=>
                            <td></td>    
                            <td>    
                                <a href="${e.url}" class="text-decoration-none has-tooltip" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar detalles"
                                target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-filetype-${e.extension}" style="font-size: 1.5rem;"></i>
                                ${e.nombre}
                                </a>
                            </td>
                        </tr>`
                });

                return $(rowItems).toArray();
            }
        </script>
    @endhasrole


    @hasrole('Administrador')
        <script>
            let dtOverrideGlobals = {
                language: dtLanguageOptions,
                paginate: true,
                ajax: {
                    url: `/unidades/{{ $item->id }}/list`,
                    dataSrc: 'data',
                },
                columns: [{
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: ``
                    },
                    {
                        data: null
                    },
                    {
                        data: null
                    },
                    {
                        data: null
                    },
                ],
                columnDefs: [{
                        targets: 1,
                        render: function(data, type, row, meta) {
                            renderHTML =
                                `<a href="/materias/${data.id}" class="btn btn-link has-tooltip" 
                                data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Mostrar detalles">
                            <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                    ${data.nombre}`
                            return renderHTML;
                        }
                    },
                    {
                        targets: 2,
                        render: function(data, type, row, meta) {
                            return `<div class="form-check form-switch">
                                    <input class="form-check-input change-status" ${data.estatus == 1 ? 'checked' : ''} 
                                    type="checkbox" role="switch" data-url="materias">
                                </div>`;
                        }
                    },
                    {
                        targets: -1,
                        render: function(data, type, row, meta) {
                            renderHTML =
                                `<button class="btn btn-sm btn-primary edit-item has-tooltip" 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" title="Editar">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-item has-tooltip" 
                                data-bs-toggle="tooltip" data-url="unidades"
                                data-bs-placement="top" title="Eliminar">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                            <button class="btn btn-sm btn-secondary upload-file has-tooltip" 
                                data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Subir archivo">
                                <i class="bi bi-upload"></i>
                            </button>`;
                            return renderHTML;
                        }
                    },
                ],
            };

            var dtContenido = $('#dtContenido').DataTable(dtOverrideGlobals);

            var itemModalElement = document.getElementById('itemModal');
            var confirmationModalElement = document.getElementById('confirmationModal');
            var uploadFileModalElement = document.getElementById('uploadFileModal');

            var itemModal = new bootstrap.Modal(itemModalElement, {
                keyboard: true
            });

            var confirmationModal = new bootstrap.Modal(confirmationModalElement, {
                keyboard: true
            });

            var uploadFileModal = new bootstrap.Modal(uploadFileModalElement, {
                keyboard: true
            });


            $('#dtContenido').on('requestChild.dt', function(e, row) {
                var data = row.data();
                row.child(format(data)).show();
            });

            $('#dtContenido').on('click', 'tbody td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = dtContenido.row(tr);

                if (row.child.isShown())
                    row.child.hide();
                else {
                    row.child(format(row.data())).show();
                }
            });

            $('.add-item').on('click', function() {
                $('#unidadForm')[0].reset();
                $('#id').val(0);
                itemModalElement.querySelector('.modal-title').textContent = 'Agregar unidad';
            });

            $('#dtContenido').on('click', 'tbody .edit-item', function() {

                var tr = $(this).closest('tr');
                var data = dtContenido.row(tr).data();

                itemModal.show();

                $('#id').val(data.id);
                $('#nombre').val(data.nombre);
                $('#estatus').prop('checked', getSwitchStatus(data.estatus));

                itemModalElement.querySelector('.modal-title').textContent = 'Editar unidad';
            });

            $('#dtContenido').on('click', 'tbody .delete-item', function() {

                const ITEM_URL = this.dataset.url;

                var tr = $(this).closest('tr');
                var data = dtContenido.row(tr).data();
                var confirmationDeleteButton = document.getElementById('confirmationDeleteButton');

                confirmationModalElement.querySelector('.modal-title').textContent = 'Eliminar';
                confirmationModalElement.querySelector('.modal-body').innerHTML =
                    `<div>
                    <i class="bi bi-exclamation-diamond-fill" style="font-size: 2.5rem; color: orange;"></i>
                </div>
                ¿Desea eliminar <span class='text-danger'>${data.nombre}</span>?`;

                confirmationModal.show();

                confirmationDeleteButton.dataset.url = `/${ITEM_URL}/${data.id}`;
                confirmationDeleteButton.dataset.type = 'DELETE'
            });

            $('#dtContenido').on('click', 'tbody .upload-file', function() {

                var tr = $(this).closest('tr');
                var data = dtContenido.row(tr).data();

                $('#unidadId').val(data.id);
                uploadFileModal.show();

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

                        dtContenido.ajax.reload();
                    },
                    error: (jqXHR, textStatus, errorThrown) => {
                        showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
                    }
                });

            });

            $('#unidadForm').on('submit', function(e) {
                var form = $('#unidadForm');
                var data = form.serialize();
                var id = $('#id');

                if (id.val() == 0) {
                    url = '/unidades'
                    type = 'POST';
                } else {
                    url = `/unidades/${id.val()}`
                    type = 'PUT';
                }

                $.ajax({
                    type: type,
                    url: url,
                    dataType: 'json',
                    data: data,
                    success: (data) => {
                        showToast(data.success, TOAST_SUCCESS_TYPE);
                        itemModal.hide();
                        form[0].reset();
                        dtContenido.ajax.reload();
                    },
                    error: (jqXHR, textStatus, errorThrown) => {
                        showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
                    }
                });
            });

            $('#fileUploadForm').on('submit', function(e) {
                const form = document.getElementById('fileUploadForm');
                const formData = new FormData(form);
                const unidadId = $('#unidadId').val();

                $.ajax({
                    type: 'POST',
                    url: `/archivos/${unidadId}`,
                    processData: false,
                    contentType: false,
                    // dataType: 'json',
                    data: formData,
                    success: (data) => {
                        showToast(data.success, TOAST_SUCCESS_TYPE);
                        uploadFileModal.hide();
                        $(form)[0].reset();
                        dtContenido.ajax.reload();
                    },
                    error: (jqXHR, textStatus, errorThrown) => {
                        showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
                    }
                });
            });

            $('#fileInput').on('change', function() {
                $('#fileName').val(this.files[0].name);
            });

            function format(data) {

                var rowItems = '';
                if (data.archivos.length == 0)
                    return `<span class="text-muted">No hay archivos disponibles</span>`

                data.archivos.forEach(e => {
                    rowItems += `<tr class=>
                            <td></td>    
                            <td>    
                                <a href="${e.url}" class="text-decoration-none has-tooltip" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar detalles"
                                target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-filetype-${e.extension}" style="font-size: 1.5rem;"></i>
                                ${e.nombre}
                                </a>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input change-status" ${data.estatus == 1 ? 'checked' : ''} 
                                    type="checkbox" role="switch" data-url="materias">
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger delete-item has-tooltip" 
                                    data-bs-toggle="tooltip" data-url="materias"
                                    data-bs-placement="top" title="Eliminar">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>`

                });

                return $(rowItems).toArray();
            }

            new bootstrap.Tooltip(document.body, {
                selector: '.has-tooltip'
            });
        </script>
    @endhasrole
@endsection
