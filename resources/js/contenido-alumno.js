import {
    dtLanguageOptions,
} from './constants'

import {
    showToast,
    TOAST_ERROR_TYPE,
    TOAST_SUCCESS_TYPE,
    confirmDialog
} from './ui';


const materia_id = document.getElementById('materiaId').value
const table = $('#table').DataTable({
    language: dtLanguageOptions,
    paginate: true,
    ajax: {
        url: `/unidades-ajax/${materia_id}`,
        dataSrc: 'data',
    },
    columns: [{
        className: 'dt-control',
        orderable: false,
        data: null,
        defaultContent: ``
    },
    { data: 'nombre' },
    ]
});

$('#detachMateria').on('click', function () {

    const request_url = `/alumnos/materias/${materia_id}`
    const request_type = 'DELETE'
    const title = 'Dar de baja'
    const item = this.dataset.name

    confirmDialog(title, item, 'confirmDetach', (confirm) => {
        if (confirm)
            $.ajax({
                url: request_url,
                type: request_type,
                success: (data) => {
                    showToast(data.success, TOAST_SUCCESS_TYPE);
                    setTimeout(function () {
                        window.location.href = "/";
                    }, 5000);
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
                }
            })
    })
});

$('#table').on('requestChild.dt', function (e, row) {
    var data = row.data();
    row.child(format(data)).show();
});

$('#table').on('click', 'tbody td.dt-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row(tr);

    if (row.child.isShown())
        row.child.hide();
    else {
        row.child(format(row.data())).show();
    }
});

function format(data) {
    var rowItems = '';
    if (data.archivos.length == 0)
        return `<span class="text-muted">No hay archivos disponibles</span>`

    data.archivos.forEach(e => {
        rowItems += `<tr>
                <td></td>    
                <td>    
                    <a href="/archivos/${e.id}" class="text-decoration-none has-tooltip" 
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