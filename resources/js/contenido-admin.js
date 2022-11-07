import * as constants from './constants'
import * as ui from './ui'

const unidad_url = 'unidades-ajax'
const archivo_url = 'archivos-ajax'

const bsItemModal = new bootstrap.Modal(itemModal)
const bsUploadFileModal = new bootstrap.Modal(uploadFileModal)

const dtOverrideGlobals = {
    language: constants.dtLanguageOptions,
    paginate: true,
    processing: true,
    stateSave: true,
    responsive: {
        details: true
    },
    ajax: {
        url: `/${unidad_url}/${materiaId.value}`,
        dataSrc: 'data',
    },
    columns: [
        {
            className: 'dt-control',
            orderable: false,
            data: null,
            defaultContent:
                ``
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
                <a href="/unidades/${data.id}/archivos/eliminados" class="btn btn-sm btn-secondary has-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="Archivos eliminados">
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
    unidadForm.reset()
    unidadId.value = 0
    uploadFileModal.querySelector('.modal-title').textContent = 'Agregar unidad'
    removeValidationStyles(unidadName)
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
            ui.showToast(data.success, 'success');
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            ui.showToast(jqXHR.responseJSON.error, 'error');
        }
    })
})

$('#table').on('click', 'tbody .edit-item', function () {
    const data = table.row(this.dataset.row).data();
    bsItemModal.show();

    unidadId.value = data.id
    unidadName.value = data.nombre
    $('#unidadStatus').prop('checked', ui.getSwitchStatus(data.estatus));

    itemModal.querySelector('.modal-title').textContent = 'Editar unidad';
    removeValidationStyles(unidadName)
});

$('#table').on('click', 'tbody .delete-item', function () {
    const data = table.row(this.dataset.row).data();
    const request_url = `/${unidad_url}/${data.id}/archive`
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

$('#table').on('click', 'tbody .upload-file', function () {
    const data = table.row(this.dataset.row).data();

    unidadId.value = data.id
    fileId.value = 0
    bsUploadFileModal.show();
    uploadFileModal.querySelector('.modal-title').textContent = 'Subir archivo'
    uploadFileForm.reset()
    $('.progress-bar').width('0%')
    $('.progress').hide()

    removeValidationStyles(fileName)
    removeValidationStyles(file)
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
            ui.showToast(data.success, 'success');
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            ui.showToast(jqXHR.responseJSON.error, 'error');
        }
    })
})

$('#table').on('click', 'tbody .edit-file', function () {
    const data = table.row(this.dataset.row).data();

    bsUploadFileModal.show()
    fileId.value = this.dataset.id
    fileName.value = this.dataset.nombre
    unidadId.value = this.dataset.unidad

    uploadFileModal.querySelector('.modal-title').textContent = 'Editar archivo'

    $('.progress').hide()

    removeValidationStyles(file)
    removeValidationStyles(fileName)
})

$('#table').on('click', 'tbody .delete-file', function () {
    const request_url = `/${archivo_url}/${this.dataset.id}/archive`
    const request_type = 'DELETE'
    const title = 'Archivar'
    const item = this.dataset.nombre

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

unidadForm.addEventListener('submit', e => {
    e.preventDefault()
    e.stopPropagation()

    const form = $('#unidadForm');
    const data = form.serialize();
    let request_url = '/unidades-ajax'
    let request_type = 'POST'

    if (unidadId.value != 0) {
        request_url = `/unidades-ajax/${unidadId.value}`
        request_type = 'PUT'
    }

    $.ajax({
        type: request_type,
        url: request_url,
        dataType: 'json',
        data: data,
        success: (data) => {
            ui.showToast(data.success, 'success');
            bsItemModal.hide();
            form[0].reset();
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            console.log(jqXHR.responseJSON.message)

            if (jqXHR.status == constants.status_unprocessable_entity) {

                const errors = jqXHR.responseJSON.errors

                if (errors.nombre) {
                    unidadName.classList.remove('is-valid')
                    unidadName.classList.add('is-invalid')
                    unidadNameInvalidFeedback.innerHTML = errors.nombre.map(e => `<li>${e}</li>`)
                }
            }

            if (jqXHR.status == constants.status_server_error) {
                error.innerHTML = jqXHR.responseJSON.error
                error.classList.remove('d-none')
            }
        }
    });
})

uploadFileForm.addEventListener('submit', e => {
    e.preventDefault()
    e.stopPropagation()

    const formData = new FormData();

    formData.append('id', fileId.value)
    formData.append('unidad_id', unidadId.value)
    formData.append('file', file.files[0])
    formData.append('nombre', fileName.value)

    let request_type = 'POST'
    let request_url = `/${archivo_url}`

    if (fileId.value != 0) {
        request_url = `/${archivo_url}/${fileId.value}`
        formData.append('_method', 'PUT')
    }

    $.ajax({
        type: request_type,
        url: request_url,
        processData: false,
        cache: false,
        contentType: false,
        data: formData,
        beforeSend: () => {
            $('.progress').show()
            $('.progress-bar').width('0%')
            console.log('loading ...')
        },
        success: (data) => {
            ui.showToast(data.success, 'success');
            bsUploadFileModal.hide();
            uploadFileForm.reset();
            table.ajax.reload();
            $('.progress').hide()
        },
        error: (jqXHR, textStatus, errorThrown) => {
            console.log(jqXHR.responseJSON.message)

            if (jqXHR.status == constants.status_unprocessable_entity) {

                const errors = jqXHR.responseJSON.errors

                if (errors.nombre) {
                    fileName.classList.remove('is-valid')
                    fileName.classList.add('is-invalid')
                    fileNameInvalidFeedback.innerHTML = errors.nombre.map(e => `<li>${e}</li>`)
                }
                if (errors.file) {
                    file.classList.remove('is-valid')
                    file.classList.add('is-invalid')
                    fileInvalidFeedback.innerHTML = errors.file.map(e => `<li>${e}</li>`)
                }
            }

            if (jqXHR.status == constants.status_server_error) {
                error.innerHTML = jqXHR.responseJSON.error
                error.classList.remove('d-none')
            }

        },
        xhr: () => {
            let xhr = new window.XMLHttpRequest()
            xhr.upload.addEventListener("progress", (event) => {
                if (event.lengthComputable) {
                    let percentComplete = ((event.loaded / event.total) * 100)
                    $('.progress-bar').width(percentComplete + '%')
                    $('.progress-bar').html(percentComplete + '%')
                    console.log(percentComplete)
                }
            }, false)

            return xhr;
        }
    })
})

$('#file').on('change', function () {
    fileName.value = this.files[0].name
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

const removeValidationStyles = (inputEl) => inputEl.classList.remove('is-invalid', 'is-valid')

unidadName.addEventListener('keydown', () => removeValidationStyles(unidadName))
fileName.addEventListener('keydown', () => removeValidationStyles(fileName))