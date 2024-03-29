import { dtLanguageOptions } from './constants'

import {
    showToast,
    confirmDialog
} from './ui';

const base_url = 'usuarios'
const confirmationModalElement = document.getElementById('confirmationModal');

const confirmationModal = new bootstrap.Modal(confirmationModalElement, {
    keyboard: true
});

let dtOverrideGlobals = {
    language: dtLanguageOptions,
    paginate: true,
    processing: true,
    stateSave: true,
    responsive: true,
    ajax: {
        url: '/usuarios/trash/list',
        dataSrc: 'data',
    },
    columns: [
        { data: null },
        { data: 'email' },
        { data: 'username' },
        { data: null },
    ],
    columnDefs: [{
        targets: 0,
        render: (data, type, row, meta) =>
            `<a href="/usuarios/${data.id}" class="btn btn-link has-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar detalles">
                <i class="bi bi-box-arrow-up-right"></i>
            </a> ${data.nombre}`
    },
    {
        targets: -1,
        render: (data, type, row, meta) =>
            `<button type="button" class="btn btn-sm btn-success restore-item has-tooltip" data-bs-toggle="tooltip"
            data-row="${meta.row}"
            data-bs-placement="top" title="Restaurar">
            <i class="bi bi-arrow-clockwise"></i>
        </button>
        <button class="btn btn-sm btn-danger delete-item has-tooltip" 
            data-row="${meta.row}"
        data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar permanentemente">
            <i class="bi bi-x"></i>
        </button>`
    },
    ],

};
const table = $('#table').DataTable(dtOverrideGlobals);

$('#table tbody').on('click', '.restore-item', function () {
    const data = table.row(this.dataset.row).data();
    const request_url = `/${base_url}/${data.id}/restore`
    const request_type = 'PUT'
    const title = 'Restaurar'
    const item = data.nombre

    confirmDialog(title, item, 'confirmRestore', function (confirm) {
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

$('#table').on('click', 'tbody .delete-item', function () {
    const data = table.row(this.dataset.row).data();
    const request_url = `/${base_url}/${data.id}`
    const request_type = 'DELETE'
    const title = 'Eliminar'
    const item = data.nombre

    confirmDialog(title, item, 'confirmDelete', function (confirm) {
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