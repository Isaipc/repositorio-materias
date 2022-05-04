@extends('layouts.dashboard')

{{-- @section('breadcrumbs', Breadcrumbs::render('alumnos.index')) --}}

@section('primary-title')
    <i class="bi bi-people-fill"></i>
    {{ __('Alumnos en materias') }}
@endsection


@section('primary-content')
    @datatable(['id' => 'dtAlumnos'])
    @slot('thead')
        <tr>
            <th>Alumno</th>
            <th>Correo</th>
        </tr>
    @endslot
    @enddatatable
@endsection

@section('secondary-content')
    @include('materias.list')
@endsection

@section('scripts')
    <script>
        let dtOverrideGlobals = {
            language: dtLanguageOptions,
            paginate: true,
            ajax: {
                url: `/alumnos/{{ $item->id }}/list`,
                dataSrc: 'data'
            },
            columns: [{
                    data: null
                },
                {
                    data: 'email' 
                }
            ],
            columnDefs: [{
                targets: 0,
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
            }]
        };

        // var itemModalElement = document.getElementById('itemModal');
        // var confirmationModalElement = document.getElementById('confirmationModal');
        // var uploadFileModalElement = document.getElementById('uploadFileModal');

        // var itemModal = new bootstrap.Modal(itemModalElement, {
        //     keyboard: true
        // });

        // var confirmationModal = new bootstrap.Modal(confirmationModalElement, {
        //     keyboard: true
        // });

        // var uploadFileModal = new bootstrap.Modal(uploadFileModalElement, {
        //     keyboard: true
        // });

        var dtAlumnos = $('#dtAlumnos').DataTable(dtOverrideGlobals);

        $('#dtAlumnos').on('requestChild.dt', function(e, row) {
            var data = row.data();
            row.child(format(data)).show();
        });

        $('#dtAlumnos').on('click', 'tbody td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = dtAlumnos.row(tr);

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

        $('#dtAlumnos').on('click', 'tbody .edit-item', function() {

            var tr = $(this).closest('tr');
            var data = dtAlumnos.row(tr).data();

            itemModal.show();

            $('#id').val(data.id);
            $('#nombre').val(data.nombre);
            $('#estatus').prop('checked', getSwitchStatus(data.estatus));

            itemModalElement.querySelector('.modal-title').textContent = 'Editar unidad';
        });

        $('#dtAlumnos').on('click', 'tbody .delete-item', function() {

            const ITEM_URL = this.dataset.url;

            var tr = $(this).closest('tr');
            var data = dtAlumnos.row(tr).data();
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

        $('#dtAlumnos').on('click', 'tbody .upload-file', function() {

            var tr = $(this).closest('tr');
            var data = dtAlumnos.row(tr).data();

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

                    dtAlumnos.ajax.reload();
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
                    dtAlumnos.ajax.reload();
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
                    dtAlumnos.ajax.reload();
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
                                <button class="btn btn-sm btn-primary edit-item has-tooltip" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" title="Editar">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
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
@endsection
