import {
    dtLanguageOptions,
} from './constants'

const materia_id = document.getElementById('materiaId').value

const dtOverrideGlobals = {
    language: dtLanguageOptions,
    paginate: true,
    responsive: true,
    ajax: {
        url: `/alumnos-en-materia/${materia_id}/`,
        dataSrc: 'data'
    },
    columns: [
        { data: null },
        { data: 'email' },
        { data: 'pivot.created_at' }
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
    }]
};

const table = $('#table').DataTable(dtOverrideGlobals)
new bootstrap.Tooltip(document.body, { selector: '.has-tooltip' })