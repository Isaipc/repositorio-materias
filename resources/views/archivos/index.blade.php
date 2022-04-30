@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.index', $item))

@section('primary-title')
    <i class="bi bi-collection-fill"></i>
    {{ $item->nombre }}
    <span class="float-end">
        <button class="btn btn-md btn-light add-item" title="Crear nuevo" data-bs-toggle="modal" data-bs-target="#itemModal">
            <i class="bi bi-plus"></i>
        </button>
        <a href="{{ route('materias.trash') }}" class="btn btn-md btn-secondary position-relative" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Mostrar eliminados">
            <i class="bi bi-trash-fill"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{-- {{ $archived->count() }} --}}
                <span class="visually-hidden"></span>
            </span>
        </a>
    </span>
@endsection

@section('primary-content')
    <!-- Save Modal -->
    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
    <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1"
                            placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
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
@endsection

@section('secondary-content')
    @include('materias.list')
@endsection

@section('scripts')
    <script>
        let dtOverrideGlobals = {
            language: {
                emptyTable: "No hay datos disponibles",
                zeroRecords: "No se encontraron resultados",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                infoEmpty: "Mostrando 0 registros",
                search: 'Buscar',
                info: "Mostrando pagina _PAGE_ de _PAGES_",
                paginate: {
                    first: "Primero",
                    last: "Ultimo",
                    next: "Siguiente",
                    previous: "Anterior"
                },
                lengthMenu: "Mostrar _MENU_ filas",

            },
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
                            `<a href="/materias/${data.id}" class="btn btn-link" data-bs-toggle="tooltip"
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
            <input class="form-check-input change-status" ${data.estatus == 1 ? 'checked' : ''} type="checkbox" role="switch"
            data-url="materias">
            </div>`;
                    }
                },
                {
                    targets: -1,
                    render: function(data, type, row, meta) {
                        renderHTML =
                            `<button class="btn btn-sm btn-primary edit-item" data-bs-toggle="modal" data-bs-target="#itemModal"
                        data-bs-placement="top" title="Editar">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-item" data-bs-toggle="tooltip" data-url="unidades"
                        data-bs-placement="top" title="Eliminar">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                    <button class="btn btn-sm btn-secondary delete-item" data-url="materias"
                        data-bs-placement="top" title="Subir archivo"
                       data-bs-toggle="modal" data-bs-target="#uploadFile">
                        <i class="bi bi-upload"></i>
                    </button>`;
                        return renderHTML;
                    }
                },
            ],
        };

        var itemModalElement = document.getElementById('itemModal');
        var confirmationModalElement = document.getElementById('confirmationModal');

        var itemModal = new bootstrap.Modal(itemModalElement, {
            keyboard: true
        });

        var confirmationModal = new bootstrap.Modal(confirmationModalElement, {
            keyboard: true
        });

        var dtContenido = $('#dtContenido').DataTable(dtOverrideGlobals);

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

        function format(data) {

            var rowItems = '';
            if (data.archivos.length == 0)
                return `<span class="text-muted">No hay archivos disponibles</span>`

            data.archivos.forEach(e => {
                rowItems += `<tr class=>
                            <td></td>    
                            <td>    
                                <a href="${e.url}" class="text-decoration-none has-tooltip" data-bs-toggle="tooltip"  data-bs-placement="top" title="Mostrar detalles">
                                <i class="bi bi-file-earmark-fill"></i>
                                ${e.nombre}
                                </a>
                            </td>
                            <td>
                        <div class="form-check form-switch">
            <input class="form-check-input change-status" ${data.estatus == 1 ? 'checked' : ''} type="checkbox" role="switch"
            data-url="materias">
            </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger delete-item has-tooltip" data-bs-toggle="tooltip" data-url="materias"
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
@endsection
