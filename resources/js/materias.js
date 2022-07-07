import {
    dtLanguageOptions,
} from './constants'

import {
    showToast,
    generateRandomKey,
    getSwitchStatus,
    TOAST_ERROR_TYPE,
    TOAST_SUCCESS_TYPE,
    confirmDialog
} from './ui';

const base_url = 'materias-ajax'

const materiaModalElement = document.getElementById('materiaModal');
const materiaModal = new bootstrap.Modal(materiaModalElement, { keyboard: true });

let dtOverrideGlobals = {
    language: dtLanguageOptions,
    paginate: true,
    processing: true,
    responsive: {
        details: true
    },
    ajax: {
        url: `/${base_url}`,
        dataSrc: 'data',
    },
    columns: [
        { data: null },
        { data: null },
        { data: 'clave' },
        { data: null }
    ],
    columnDefs: [{
        targets: 0,
        render: (data, type, row, meta) =>
            `<a href="/materias/${data.id}" class="btn btn-link has-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar detalles">
                <i class="bi bi-box-arrow-up-right"></i>
            </a>${data.nombre}`
    },
    {
        targets: 1,
        render: (data, type, row, meta) =>
            `<div class="form-check form-switch">
                <input class="form-check-input change-status" ${data.estatus == 1 ? 'checked' : ''} type="checkbox" role="switch"
                    data-row="${meta.row}">
            </div>`
    },
    {
        targets: 2,
        render: (data, type, row, meta) =>
            `<span class="alert alert-primary px-2 py-0">${data}</span>`
    },
    {
        targets: -1,
        render: (data, type, row, meta) =>
            `<div>
                <button class="btn btn-sm btn-primary edit-item has-tooltip"
                    data-row="${meta.row}"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                    <i class="bi bi-pencil-fill"></i>
                </button>
                <button class="btn btn-sm btn-danger delete-item has-tooltip"
                    data-row="${meta.row}"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                    <i class="bi bi-trash-fill"></i>
                </button>
                <a href="/materias/${data.id}/contenido" class="btn btn-sm btn-light has-tooltip" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Mostrar contenido">
                    <i class="bi bi-file-earmark-fill"></i>
                </a>
                <a href="/materias/${data.id}/alumnos" class="btn btn-sm btn-light has-tooltip" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Mostrar alumnos">
                    <i class="bi bi-people-fill"></i>
                </a>
            </div>`
    },
    ],

};
const table = $('#table').DataTable(dtOverrideGlobals);

$('#addMateria').on('click', function () {
    materiaModal.show();
    $('#materiaForm')[0].reset();
    $('#materiaId').val(0);
    $('#clave').val(generateRandomKey());
    materiaModalElement.querySelector('.modal-title').textContent = 'Agregar materia';
});

$('#materiaForm').on('submit', function (e) {
    var form = $('#materiaForm');
    var data = form.serialize();
    var id = $('#materiaId');
    let url = '/materias-ajax'
    let type = 'POST'

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
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            showToast(jqXHR.responseJSON.message, TOAST_ERROR_TYPE);
        }
    });
});

$('#table').on('click', 'tbody .edit-item', function () {
    const data = table.row(this.dataset.row).data();
    materiaModal.show();

    $('#materiaId').val(data.id);
    $('#nombre').val(data.nombre);
    $('#estatus').prop('checked', getSwitchStatus(data.estatus));
    $('#clave').val(data.clave);

    materiaModalElement.querySelector('.modal-title').textContent = 'Editar materia';
});

$('#table').on('click', 'tbody .delete-item', function () {
    const data = table.row(this.dataset.row).data();
    const request_url = `/materias-ajax/${data.id}/archive`
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

$('#buttonRandomKey').on('click', function () {
    $('#clave').val(generateRandomKey());

});

$('#table tbody').on('change', '.change-status', function () {
    const data = table.row(this.dataset.row).data();
    const ITEM_STATUS = this.checked;

    $.ajax({
        type: 'PUT',
        url: `/${base_url}/${data.id}/change-status`,
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
    });

});