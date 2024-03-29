import * as ui from './ui'
import * as constants from './constants'

const materia_id = document.getElementById('materiaId').value

const dtOverrideGlobals = {
    language: constants.dtLanguageOptions,
    paginate: true,
    responsive: true,
    ajax: {
        url: `/alumnos-en-materia/${materia_id}/`,
        dataSrc: 'data'
    },
    columns: [
        { data: null },
        { data: 'email' },
        { data: 'pivot.created_at' },
        { data: null },
    ],
    columnDefs: [{
        targets: 0,
        render: (data, type, row, meta) =>
            `<a href="/usuarios/${data.id}" class="btn btn-link has-tooltip" 
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar detalles">
                <i class="bi bi-box-arrow-up-right"></i>
            </a>
            ${data.nombre}`
    },
    {
        targets: 2,
        render: (data, type, row, meta) => `${_moment(data).fromNow()}`
    },
    {
        targets: -1,
        render: (data, type, row, meta) =>
            `<div>
                <button class="btn btn-sm btn-danger delete-item has-tooltip"
                    data-row="${meta.row}"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Quitar participante">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </div>`
    }]
};

$('#table').on('click', 'tbody .delete-item', function () {
    const data = table.row(this.dataset.row).data();
    console.log(data)
    const request_url = `/alumnos-en-materia/quitar/${materia_id}/${data.id}/`
    const request_type = 'DELETE'
    const title = 'Quitar participante'
    const body = 
        `<div>
            <i class="bi bi-exclamation-diamond-fill" style="font-size: 2.5rem; color: orange;"></i>
        </div>
        ¿Desea quitar el participante <span class='text-danger'>${data.nombre}</span> de este curso?`
 

    ui.confirmDialog(title, body, '', (confirm) => {
        if (confirm)
            $.ajax({
                type: request_type,
                url: request_url,
                success: (data) => {
                    ui.showToast(data.success, 'success');
                    table.ajax.reload();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    ui.showToast(jqXHR.responseJSON.error, 'error');
                }
            })
    })
})

$('#closeCourse').on('click', function () {
    const request_url = `/alumnos-en-materia/close-course/${this.dataset.id}`
    const request_type = 'DELETE'
    const title = 'Cerrar curso'
    const body = 
        `<div>
            <i class="bi bi-exclamation-diamond-fill" style="font-size: 2.5rem; color: orange;"></i>
        </div>
        ¿Desea cerrar este curso? Esto quitará el acceso a todos los participantes a su contenido.`
 

    ui.confirmDialog(title, body, '', (confirm) => {
        if (confirm)
            $.ajax({
                type: request_type,
                url: request_url,
                success: (data) => {
                    ui.showToast(data.success, 'success');
                    table.ajax.reload();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    ui.showToast(jqXHR.responseJSON.error, 'error');
                }
            })
    })
})

const table = $('#table').DataTable(dtOverrideGlobals)
new bootstrap.Tooltip(document.body, { selector: '.has-tooltip' })