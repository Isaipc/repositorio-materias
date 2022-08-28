import * as ui from './ui'
import * as constants from './constants'

const base_url = 'materias-ajax'

const materiaModalElement = document.getElementById('materiaModal');
const materiaModal = new bootstrap.Modal(materiaModalElement, { keyboard: true });
const materiaForm = document.getElementById('materiaForm')
const error = document.getElementById('error')
const nombre = document.getElementById('nombre')
const clave = document.getElementById('clave')
const nombreInvalidFeedback = document.getElementById('nombreInvalidFeedback')
const claveInvalidFeedback = document.getElementById('claveInvalidFeedback')

let dtOverrideGlobals = {
    language: _.dtLanguageOptions,
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
            `${data.nombre}
            <a href="/materias/${data.id}" class="btn btn-link has-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar detalles">
                <i class="bi bi-box-arrow-up-right"></i>
            </a>`
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
                <a href="/materias/${data.id}/unidades" class="btn btn-sm btn-light has-tooltip" data-bs-toggle="tooltip"
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
    materiaForm.reset()
    materiaForm.classList.remove('was-validated')
    error.classList.add('d-none')
    removeValidationStyles(nombre)
    removeValidationStyles(clave)
    $('#materiaId').val(0);
    $('#clave').val(ui.generateRandomKey());
    materiaModalElement.querySelector('.modal-title').textContent = 'Agregar materia';
})

const removeValidationStyles = (inputEl) => inputEl.classList.remove('is-invalid', 'is-valid')

nombre.addEventListener('keydown', () => removeValidationStyles(nombre))
clave.addEventListener('keydown', () => removeValidationStyles(clave))

materiaForm.addEventListener('submit', e => {

    e.preventDefault()
    e.stopPropagation()

    var form = $('#materiaForm');
    var data = form.serialize();
    var id = $('#materiaId');
    let url = '/materias-ajax'
    let type = 'POST'

    if (id.val() != 0) {
        url = `/materias-ajax/${id.val()}`
        type = 'PUT';
    }

    $.ajax({
        type: type,
        url: url,
        dataType: 'json',
        data: data,
        success: (data) => {
            ui.showToast(data.success, 'success');
            materiaModal.hide();
            form[0].reset();
            materiaForm.classList.add('was-validated')
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            console.log(jqXHR.responseJSON.message)

            if (jqXHR.status == constants.status_unprocessable_entity) {

                const errors = jqXHR.responseJSON.errors

                if (errors.nombre) {
                    nombre.classList.remove('is-valid')
                    nombre.classList.add('is-invalid')
                    nombreInvalidFeedback.innerHTML = errors.nombre.map(e => `<li>${e}</li>`)
                }
                if (errors.clave) {
                    clave.classList.remove('is-valid')
                    clave.classList.add('is-invalid')
                    claveInvalidFeedback.innerHTML = errors.clave.map(e => `<li>${e}</li>`)
                }
            }

            if (jqXHR.status == constants.status_server_error) {
                error.innerHTML = jqXHR.responseJSON.error
                error.classList.remove('d-none')
            }
        }
    })


}, false)

$('#table').on('click', 'tbody .edit-item', function () {
    const data = table.row(this.dataset.row).data();
    materiaModal.show();
    materiaForm.classList.remove('was-validated')

    $('#materiaId').val(data.id);
    $('#nombre').val(data.nombre);
    $('#estatus').prop('checked', ui.getSwitchStatus(data.estatus));
    $('#clave').val(data.clave);

    materiaModalElement.querySelector('.modal-title').textContent = 'Editar materia';
});

$('#table').on('click', 'tbody .delete-item', function () {
    const data = table.row(this.dataset.row).data();
    const request_url = `/materias-ajax/${data.id}/archive`
    const request_type = 'DELETE'
    const title = 'Archivar'
    const item = data.nombre

    ui.confirmDialog(title, item, 'confirmArchive', (confirm) => {
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

$('#buttonRandomKey').on('click', function () {
    $('#clave').val(ui.generateRandomKey());

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
            ui.showToast(data.success, 'success');
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            ui.showToast(jqXHR.responseJSON.error, 'error');
        }
    });

});