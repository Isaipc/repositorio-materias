import {
    dtLanguageOptions,
} from './constants'

import {
    showToast,
    TOAST_ERROR_TYPE,
    TOAST_SUCCESS_TYPE,
    confirmDialog
} from './ui';

const userModalElement = document.getElementById('userModal');
const userModal = new bootstrap.Modal(userModalElement, {
    keyboard: true
});

let dtOverrideGlobals = {
    language: dtLanguageOptions,
    paginate: true,
    stateSave: true,
    processing: true,
    responsive: true,
    ajax: {
        url: '/usuarios/list',
        dataSrc: 'data',
    },
    columns: [
        { data: null },
        { data: 'nombre' },
        { data: 'email' },
        { data: 'username' },
        { data: 'materias' },
        { data: null }
    ],
    columnDefs: [{
        targets: 0,
        render: (data, type, row, meta) =>
            `<a href="/usuarios/${data.id}" class="btn btn-link" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Mostrar detalles">
                    <i class="bi bi-box-arrow-up-right"></i>
            </a>`
    },
    {
        targets: 4,
        render: function (data, type, row, meta) {
            let renderHTML = '';

            if (data.length > 0) {
                data.forEach(e => {
                    renderHTML +=
                        `<li>
                                    <a href="/materias/${e.id}" class="btn btn-link text-decoration-none"> 
                                            ${e.nombre}
                                            </a>
                                            </li>`
                });
            } else {
                renderHTML = `<span class="text-muted">Sin materias</span>`;
            }
            return renderHTML;
        }
    },
    {
        targets: -1,
        render: (data, type, row, meta) =>
            `<a href="/usuarios/${data.id}/editar" class="btn btn-sm btn-primary has-tooltip" 
            data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"> 
            <i class="bi bi-pencil-fill"></i></a>
            <button class="btn btn-sm btn-danger delete-item has-tooltip" 
            data-row="${meta.row}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
            <i class="bi bi-trash-fill"></i></button>`
    },
    ],
};

const table = $('#table').DataTable(dtOverrideGlobals)

$('#addUser').on('click', function () {
    userModal.show();
    $('#userForm')[0].reset();
    $('#userId').val(0);
    userModalElement.querySelector('.modal-title').textContent = 'Nuevo alumno';
});

$('#userForm').on('submit', function (e) {
    var form = $('#userForm');
    var data = form.serialize();
    var id = $('#userId');

    if (id.val() == 0) {
        url = '/usuarios'
        type = 'POST';
    }

    $.ajax({
        type: type,
        url: url,
        dataType: 'json',
        data: data,
        success: (data) => {
            showToast(data.success, TOAST_SUCCESS_TYPE);
            userModal.hide();
            form[0].reset();
            table.ajax.reload();
        },
        error: (jqXHR, textStatus, errorThrown) => {
            console.log(jqXHR.responseJSON);
            showToast(jqXHR.responseJSON.errors.nombre, TOAST_ERROR_TYPE);
        }
    });
});

$('#table').on('click', 'tbody .edit-item', function () {
    const data = table.row(this.dataset.row).data();
    userModal.show();

    $('#userId').val(data.id);
    $('#nombre').val(data.nombre);
    $('#username').val(data.username);
    $('#email').val(data.email);
    userModalElement.querySelector('.modal-title').textContent = 'Editar usuario';
})

$('#table').on('click', 'tbody .delete-item', function () {
    const data = table.row(this.dataset.row).data();
    const request_url = `/usuarios/${data.id}/archive`
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