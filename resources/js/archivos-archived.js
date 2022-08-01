import { dtLanguageOptions, } from './constants'
import { showToast, confirmDialog } from './ui';

const base_url = 'archivos-ajax'
const unidad_id = document.getElementById('unidadId').value

const dtOverrideGlobals = {
    language: dtLanguageOptions,
    paginate: true,
    processing: true,
    stateSave: true,
    responsive: {
        details: true
    },
    ajax: {
        url: `/${base_url}/${unidad_id}/trash`,
        dataSrc: 'data',
    },
    columns: [
        { data: 'nombre' },
        { data: 'updated_at' },
        { data: null },
    ],
    columnDefs: [
        {
            targets: -1,
            render: (data, type, row, meta) =>
                `<button type="button" class="btn btn-sm btn-success restore-item has-tooltip" 
                    data-bs-toggle="tooltip"
                    data-row="${meta.row}"
                    data-bs-placement="top" title="Restaurar">
                    <i class="bi bi-arrow-clockwise"></i>
                </button>
                <button class="btn btn-sm btn-danger delete-item has-tooltip" 
                    data-row="${meta.row}"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar permanentemente">
                    <i class="bi bi-x"></i>
                </button>`
        }
    ]
}
const table = $('#table').DataTable(dtOverrideGlobals)

$('#table tbody').on('click', '.restore-item', function () {
    const data = table.row(this.dataset.row).data();
    const request_url = `/${base_url}/${data.id}/restore`
    const request_type = 'PUT'
    const title = 'Restaurar'
    const item = data.nombre

    confirmDialog(title, item, 'confirmRestore', (confirm) => {
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

    confirmDialog(title, item, 'confirmDelete', (confirm) => {
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

new bootstrap.Tooltip(document.body, { selector: '.has-tooltip' })