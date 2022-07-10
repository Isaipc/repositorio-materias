import {
    dtLanguageOptions,
} from './constants'

import {
    showToast,
    getSwitchStatus,
    TOAST_ERROR_TYPE,
    TOAST_SUCCESS_TYPE,
    confirmDialog
} from './ui';

const unidad_url = 'unidades-ajax'
const archivo_url = 'archivos-ajax'
const materia_id = document.getElementById('materiaId').value
const itemModalElement = document.getElementById('itemModal');
const uploadFileModalElement = document.getElementById('uploadFileModal');

const itemModal = new bootstrap.Modal(itemModalElement);
const uploadFileModal = new bootstrap.Modal(uploadFileModalElement);

const dtOverrideGlobals = {
    language: dtLanguageOptions,
    paginate: true,
    processing: true,
    stateSave: true,
    responsive: {
        details: true
    },
    ajax: {
        url: `/${unidad_url}/${materia_id}`,
        dataSrc: 'data',
    },
    columns: [
        {
            className: 'dt-control',
            orderable: false,
            data: null,
            defaultContent: ``
        },
        { data: 'nombre' },
        { data: null },
        { data: null },
    ],
    columnDefs: [
        {
            targets: 2,
            render: (data, type, row, meta) =>
                `<div class="form-check form-switch">
                    <input class="form-check-input change-status" ${data.estatus == 1 ? 'checked' : ''} 
                    data-row="${meta.row}"
                    type="checkbox" role="switch">
                </div>`
        },
        {
            targets: -1,
            render: (data, type, row, meta) =>
                `<button class="btn btn-sm btn-primary edit-item has-tooltip" data-row="${meta.row}"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                    <i class="bi bi-pencil-fill"></i>
                </button>
                <button class="btn btn-sm btn-danger delete-item has-tooltip" data-row="${meta.row}"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                    <i class="bi bi-trash-fill"></i>
                </button>
                <button class="btn btn-sm btn-secondary upload-file has-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Subir archivo">
                    <i class="bi bi-upload"></i>
                </button>`
        }
    ],

};
const table = $('#table').DataTable(dtOverrideGlobals);
$('#table').on('requestChild.dt', function (e, row) {
    const data = row.data();
    row.child(format(data)).show();
});

$('#table').on('click', 'tbody td.dt-control', function () {
    const tr = $(this).closest('tr');
    const row = table.row(tr);

    if (row.child.isShown())
        row.child.hide();
    else {
        row.child(format(row.data())).show();
    }
});

$('.add-item').on('click', function () {
    $('#unidadForm')[0].reset();
    $('#id').val(0);
    itemModalElement.querySelector('.modal-title').textContent = 'Agregar unidad';
});

$('#table tbody').on('change', '.change-status', function () {
    const data = table.row(this.dataset.row).data();
    const ITEM_STATUS = this.checked;

    $.ajax({
        type: 'PUT',
        url: `/unidades-ajax/${data.id}/change-status`,
        dataType: 'json',
        data: {
            id: data.id,
            estatus: ITEM_STATUS
        },
        success: (data) => {
            showToast(data.success, TOAST_SUCCESS_TYPE);
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
        }
    })
})

$('#table').on('click', 'tbody .edit-item', function () {
    const data = table.row(this.dataset.row).data();
    itemModal.show();

    $('#id').val(data.id);
    $('#nombre').val(data.nombre);
    $('#estatus').prop('checked', getSwitchStatus(data.estatus));

    itemModalElement.querySelector('.modal-title').textContent = 'Editar unidad';
});

$('#table').on('click', 'tbody .delete-item', function () {
    const data = table.row(this.dataset.row).data();
    const request_url = `/${unidad_url}/${data.id}/archive`
    const request_type = 'DELETE'
    const title = 'Archivar'
    const item = data.nombre

    confirmDialog(title, item, 'confirmArchive', (confirm) => {
        if (confirm)
            $.ajax({
                type: request_type,
                url: request_url,
                success: (data) => {
                    showToast(data.success, TOAST_SUCCESS_TYPE);
                    table.ajax.reload();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
                }
            })
    })
})

$('#table').on('click', 'tbody .upload-file', function () {
    const data = table.row(this.dataset.row).data();

    $('#unidadId').val(data.id);
    uploadFileModal.show();
});

$('#unidadForm').on('submit', function (e) {
    const form = $('#unidadForm');
    const data = form.serialize();
    const id = $('#id');
    let request_url = '/unidades-ajax'
    let request_type = 'POST'

    if (id.val() != 0) {
        request_url = `/unidades-ajax/${id.val()}`
        request_type = 'PUT'
    }

    $.ajax({
        type: request_type,
        url: request_url,
        dataType: 'json',
        data: data,
        success: (data) => {
            showToast(data.success, TOAST_SUCCESS_TYPE);
            itemModal.hide();
            form[0].reset();
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
        }
    });
});

$('#fileUploadForm').on('submit', function (e) {
    const form = document.getElementById('fileUploadForm');
    const formData = new FormData(form);
    const unidadId = $('#unidadId').val();

    $.ajax({
        type: 'POST',
        url: `/${archivo_url}/${unidadId}`,
        processData: false,
        contentType: false,
        // dataType: 'json',
        data: formData,
        success: (data) => {
            showToast(data.success, TOAST_SUCCESS_TYPE);
            uploadFileModal.hide();
            $(form)[0].reset();
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
        }
    });
});

$('#fileInput').on('change', function () {
    $('#fileName').val(this.files[0].name);
});

function format(data) {

    var rowItems = '';
    if (data.archivos.length == 0)
        return `<span class="text-muted">No hay archivos disponibles</span>`

    data.archivos.forEach(e => {
        rowItems += `<tr>
                <td></td>    
                <td>    
                    <a href="/archivos/${e.id}/${e.nombre}" class="text-decoration-none has-tooltip" 
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar detalles"
                    target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-filetype-${e.extension}" style="font-size: 1.2rem;"></i>
                    ${e.nombre}
                    </a>
                </td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input change-status" ${data.estatus == 1 ? 'checked' : ''} 
                        type="checkbox" role="switch">
                    </div>
                </td>
                <td>
                    <button class="btn btn-sm btn-primary edit-item has-tooltip" 
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-item has-tooltip" 
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                        <i class="bi bi-trash-fill"></i>
                    </button>
            </td>
        </tr>`

    });

    return $(rowItems).toArray();
}

new bootstrap.Tooltip(document.body, { selector: '.has-tooltip' })