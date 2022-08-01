import {
    dtLanguageOptions,
} from './constants'

import {
    showToast,
    getSwitchStatus,
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
                <button class="btn btn-sm btn-secondary upload-file has-tooltip" data-bs-toggle="tooltip"  data-row="${meta.row}" data-bs-placement="top" title="Subir archivo">
                    <i class="bi bi-upload"></i>
                </button>
                <a href="/archivos/${data.id}/eliminados" class="btn btn-sm btn-secondary has-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Archivos eliminados">
                    <i class="bi bi-trash"></i>
                </a>
                `
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
            showToast(data.success, 'success');
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            showToast(jqXHR.responseJSON.error, 'error');
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
                    showToast(data.success, 'success');
                    table.ajax.reload();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    showToast(jqXHR.responseJSON.error, 'error');
                }
            })
    })
})

$('#table').on('click', 'tbody .upload-file', function () {
    const data = table.row(this.dataset.row).data();

    $('#unidadId').val(data.id);
    $('#fileId').val(0);
    uploadFileModal.show();
    uploadFileModalElement.querySelector('.modal-title').textContent = 'Subir archivo'
});

$('#table tbody').on('change', '.change-status-file', function () {
    const ITEM_STATUS = this.checked;

    $.ajax({
        type: 'PUT',
        url: `/${archivo_url}/${this.dataset.id}/change-status`,
        dataType: 'json',
        data: {
            id: this.dataset.id,
            estatus: ITEM_STATUS
        },
        success: (data) => {
            showToast(data.success, 'success');
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            showToast(jqXHR.responseJSON.error, 'error');
        }
    })
})

$('#table').on('click', 'tbody .edit-file', function () {
    const data = table.row(this.dataset.row).data();

    uploadFileModal.show()
    $('#fileId').val(this.dataset.id)
    $('#fileName').val(this.dataset.nombre)
    $('#unidadId').val(this.dataset.unidad);

    uploadFileModalElement.querySelector('.modal-title').textContent = 'Editar archivo'
})

$('#table').on('click', 'tbody .delete-file', function () {
    const request_url = `/${archivo_url}/${this.dataset.id}/archive`
    const request_type = 'DELETE'
    const title = 'Archivar'
    const item = this.dataset.nombre

    confirmDialog(title, item, 'confirmArchive', (confirm) => {
        if (confirm)
            $.ajax({
                type: request_type,
                url: request_url,
                success: (data) => {
                    showToast(data.success, 'success');
                    table.ajax.reload();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    showToast(jqXHR.responseJSON.error, 'error');
                }
            })
    })
})

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
            showToast(data.success, 'success');
            itemModal.hide();
            form[0].reset();
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            showToast(jqXHR.responseJSON.error, 'error');
        }
    });
});

$('#fileUploadForm').on('submit', function (e) {
    e.preventDefault()
    const form = document.getElementById('fileUploadForm');
    const id = document.getElementById('fileId').value
    const file = document.getElementById('file').files[0]
    const unidadId = document.getElementById('unidadId').value
    const nombre = document.getElementById('fileName').value
    const formData = new FormData();

    formData.append('id', id)
    formData.append('unidad_id', unidadId)
    formData.append('file', file)
    formData.append('nombre', nombre)

    let request_type = 'POST'
    let request_url = `/${archivo_url}`

    if (id != 0) {
        request_url = `/${archivo_url}/${id}`
        formData.append('_method', 'PUT')
    }

    $.ajax({
        type: request_type,
        url: request_url,
        processData: false,
        contentType: false,
        // dataType: 'json',
        data: formData,
        success: (data) => {
            showToast(data.success, 'success');
            uploadFileModal.hide();
            $(form)[0].reset();
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            showToast(jqXHR.responseJSON.error, 'error');
        }
    })
})

$('#file').on('change', function () {
    $('#fileName').val(this.files[0].name);
});

function format(data) {
    if (data.archivos.length == 0)
        return `<span class="text-muted">No hay archivos disponibles</span>`

    const result = data.archivos.reduce((acc, e) => {
        return acc + `<tr>
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
                        <input class="form-check-input change-status-file" ${e.estatus == 1 ? 'checked' : ''} 
                        data-id="${e.id}"
                        type="checkbox" role="switch">
                    </div>
                </td>
                <td>
                    <button class="btn btn-sm btn-primary edit-file has-tooltip" 
                        data-id="${e.id}" data-nombre="${e.nombre}"
                        data-unidad="${data.id}"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                    <button class="btn btn-sm btn-danger delete-file has-tooltip" 
                        data-id="${e.id}" data-nombre="${e.nombre}"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                        <i class="bi bi-trash-fill"></i>
                    </button>
            </td>
        </tr>`

    }, '');

    return $(result).toArray();
}

new bootstrap.Tooltip(document.body, { selector: '.has-tooltip' })