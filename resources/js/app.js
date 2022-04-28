/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('jquery-validation');
require('./bootstrap');
require('bootstrap-select');
require('bootstrap-icons/font/bootstrap-icons');

require('datatables.net-bs5')

const dateFormat = 'DD/MM/YYYY';
const TOAST_ERROR_TYPE = 1;
const TOAST_SUCCESS_TYPE = 0;

var today = new Date();

$(function ($) {

    // DataTables SETUP

    let dtButtons = $.extend(true, [], $.fn.DataTable.defaults.buttons);
    let dtLanguageOptions = {
        emptyTable: "No hay datos disponibles",
        zeroRecords: "No se encontraron resultados",
        infoFiltered: "(filtrado de _MAX_ registros totales)",
        infoEmpty: "Mostrando 0 registros",
        search: 'Buscar',
        info: "Mostrando pagina _PAGE_ de _PAGES_",
        paginate: {
            first: "Primero",
            last: "Ultimo",
            next: "Siguiente",
            previous: "Anterior"
        },
        lengthMenu: "Mostrar _MENU_ filas",
        processing: 'Procesando ...'
    };

    let materiasDtOverrideGlobals = {
        language: dtLanguageOptions,
        paginate: true,
        processing: true,
        stateSave: true,
        ajax: {
            url: '/materias/list',
            dataSrc: 'data',
        },
        columns: [
            { data: null },
            { data: null },
            { data: null },
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    renderHTML =
                        `<a href="/materias/${data.id}" class="btn btn-link" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Mostrar detalles">
                                <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                        ${data.nombre}`
                    return renderHTML;
                }
            },
            {
                targets: -1,
                render: function (data, type, row, meta) {
                    renderHTML =
                        `<a href="/materias/${data.id}/editar" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Editar">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <button class="btn btn-sm btn-danger delete-item" data-bs-toggle="tooltip" data-url="materias"
                        data-bs-placement="top" title="Eliminar">
                        <i class="bi bi-trash-fill"></i>
                    </button>
                    <a href="/materias/${data.id}/archivos" class="btn btn-sm btn-light" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Mostrar contenido">
                        <i class="bi bi-file-earmark-fill"></i>
                        Contenido
                    </a>`;
                    return renderHTML;
                }
            },
            {
                targets: 1,
                render: function (data, type, row, meta) {
                    return `<div class="form-check form-switch">
                    <input class="form-check-input change-status" ${data.estatus == 1 ? 'checked' : ''} type="checkbox" role="switch"
                    data-url="materias">
                    </div>`;
                }
            }
        ],

    };

    let materiasTrashDtOverrideGlobals = {
        language: dtLanguageOptions,
        paginate: true,
        processing: true,
        stateSave: true,
        ajax: {
            url: '/materias/trash/list',
            dataSrc: 'data',
        },
        columns: [
            { data: null },
            { data: null },
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    renderHTML =
                        `<a href="/materias/${data.id}" class="btn btn-link" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Mostrar detalles">
                                <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                        ${data.nombre}`
                    return renderHTML;
                }
            },
            {
                targets: -1,
                render: function (data, type, row, meta) {
                    renderHTML =
                        `<button type="button" class="btn btn-sm btn-success restore-item" data-bs-toggle="tooltip"
                        data-url="materias" data-bs-placement="top" title="Restaurar">
                        <i class="bi bi-arrow-clockwise"></i>
                        </button>`;
                    return renderHTML;
                }
            },
        ],

    };

    let usersDtOverrideGlobals = {
        language: dtLanguageOptions,
        paginate: true,
        stateSave: true,
        processing: true,
        ajax: {
            url: '/usuarios/list',
            dataSrc: 'data',
        },
        columns: [
            { data: null },
            { data: 'email' },
            { data: 'username' },
            { data: null },
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    renderHTML =
                        `<a href="/usuarios/${data.id}" class="btn btn-link" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Mostrar detalles">
                                <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                        ${data.nombre}`
                    return renderHTML;
                }
            },
            {
                targets: -1,
                render: function (data, type, row, meta) {
                    renderHTML =
                        `<a href="/usuarios/${data.id}/editar" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Editar">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <button class="btn btn-sm btn-danger delete-item" data-bs-toggle="tooltip"
                        data-bs-placement="top" 
                        data-url="usuarios" data-type="DELETE" title="Eliminar">
                        <i class="bi bi-trash-fill"></i>
                    </button>`;
                    return renderHTML;
                }
            },
        ],

    };

    let usersTrashDtOverrideGlobals = {
        language: dtLanguageOptions,
        processing: true,
        paginate: true,
        stateSave: true,
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
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta) {
                    renderHTML =
                        `<a href="/usuarios/${data.id}" class="btn btn-link" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Mostrar detalles">
                                <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                        ${data.nombre}`
                    return renderHTML;
                }
            },
            {
                targets: -1,
                render: function (data, type, row, meta) {
                    renderHTML =
                        `<button type="button" class="btn btn-sm btn-success restore-item" data-bs-toggle="tooltip"
                        data-url="usuarios" data-bs-placement="top" title="Restaurar">
                        <i class="bi bi-arrow-clockwise"></i>
                        </button>`;
                    return renderHTML;
                }
            },
        ],
    };

    var materiasDataTable = $('#materiasDT').DataTable(materiasDtOverrideGlobals);
    var materiasTrashDataTable = $('#materiasTrashDT').DataTable(materiasTrashDtOverrideGlobals);
    var usuariosDataTable = $('#usuariosDT').DataTable(usersDtOverrideGlobals);
    var usuariosTrashDataTable = $('#usuariosTrashDT').DataTable(usersTrashDtOverrideGlobals);

    var modalConfirmBtn = document.getElementById('confirmBtn');
    var modalTitle = confirmDialog.querySelector('.modal-title');
    var modalMsg = confirmDialog.querySelector('.modal-msg');

    $('.datatable tbody').on('click', '.restore-item', function () {

        const ITEM_URL = this.dataset.url;

        if (ITEM_URL == 'materias')
            data = materiasTrashDataTable.row($(this).parents('tr')).data();
        else if (ITEM_URL == 'usuarios')
            data = usuariosTrashDataTable.row($(this).parents('tr')).data();

        modal.show();

        modalTitle.textContent = 'Restaurar';
        modalMsg.textContent = '¿Estas seguro que desea restaurar "' + data.nombre + '"?'

        modalConfirmBtn.dataset.url = `/${ITEM_URL}/${data.id}/restaurar`;
        modalConfirmBtn.dataset.type = 'PUT';
    });

    $('.datatable tbody').on('click', '.delete-item', function () {

        const ITEM_URL = this.dataset.url;

        if (ITEM_URL == 'materias')
            data = materiasDataTable.row($(this).parents('tr')).data();
        else if (ITEM_URL == 'usuarios')
            data = usuariosDataTable.row($(this).parents('tr')).data();


        modal.show();

        modalTitle.textContent = 'Eliminar';
        modalMsg.textContent = '¿Estas seguro que desea eliminar "' + data.nombre + '"?'

        modalConfirmBtn.dataset.url = `/${ITEM_URL}/${data.id}`;
        modalConfirmBtn.dataset.type = 'DELETE'
    });

    $('#confirmBtn').on('click', (e) => {
        modal.hide();

        const ITEM_URL = e.currentTarget.dataset.url;
        const ITEM_TYPE = e.currentTarget.dataset.type;

        $.ajax({
            type: ITEM_TYPE,
            url: ITEM_URL,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: (data) => {
                showToast(data.success, TOAST_SUCCESS_TYPE);
                materiasDataTable.ajax.reload();
                materiasTrashDataTable.ajax.reload();
                usuariosDataTable.ajax.reload();
                usuariosTrashDataTable.ajax.reload();
            },
            error: (jqXHR, textStatus, errorThrown) => {
                showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
            }
        });
    });

    $('#materiaForm').on('submit', function (e) {

        var form = $('#materiaForm');
        var data = form.serialize();
        var itemId = $('#itemId');

        if (itemId.val() == 0) {
            url = '/materias'
            type = 'POST';
        }
        else {
            url = `/materias/${itemId.val()}`
            type = 'PUT';
        }

        $.ajax({
            type: type,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: url,
            dataType: 'json',
            data: data,
            success: (data) => {
                showToast(data.success, TOAST_SUCCESS_TYPE);
                materiasDataTable.ajax.reload();
                usuariosDataTable.ajax.reload();
            },
            error: (jqXHR, textStatus, errorThrown) => {
                showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
            }
        });
    });

    $('.datatable tbody').on('change', '.change-status', function () {

        var data = materiasDataTable.row($(this).parents('tr')).data();

        const ITEM_URL = this.dataset.url;
        const ITEM_STATUS = this.checked;

        $.ajax({
            type: 'PUT',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: `/${ITEM_URL}/${data.id}/change-status`,
            dataType: 'json',
            data: {
                id: data.id,
                estatus: ITEM_STATUS
            },
            success: (data) => {
                showToast(data.success, TOAST_SUCCESS_TYPE);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
            }
        });

    });


});

function showToast(msg, type) {

    var toastElement = document.getElementById('toast');
    var toastElementHeader = toastElement.querySelector('.toast-header');
    var toastElementTitle = toastElement.querySelector('.toast-title');
    var toastElementBody = toastElement.querySelector('.toast-body');
    switch (type) {
        case 0:
            toastElementHeader.classList.remove('bg-danger');
            toastElementHeader.classList.add('bg-success');
            toastElementTitle.textContent = 'Completado';
            break;
        case 1:
            toastElementHeader.classList.remove('bg-success');
            toastElementHeader.classList.add('bg-danger');
            toastElementTitle.textContent = 'Error';
            break;
    }
    toastElementBody.textContent = msg;

    var toast = bootstrap.Toast.getInstance(toastElement);
    toast.show();
}

// INIT BOOTSTRAP COMPONENTS
var confirmDialog = document.getElementById('confirmDialog');
var modal = new bootstrap.Modal(confirmDialog, {
    keyboard: true
});

// initialize all toast 
const option = [];
var toastElementList = [].slice.call(document.querySelectorAll('.toast'))
var toastList = toastElementList.map(function (toastE) {
    return new bootstrap.Toast(toastE, option);
});

// initialize all dropdowns 
var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
    dropdown = new bootstrap.Dropdown(dropdownToggleEl)
    return dropdown;
});

// initialize all tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});