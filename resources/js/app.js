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
    $('.datatable').DataTable({
        satateSave: true,
        paginate: true,
        language: {
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
        }
    });

    // AJAX SETUP
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
    });

    $('.change-status').on('change', (e) => {
        const ITEM_ID = e.currentTarget.dataset.id;
        const ITEM_URL = e.currentTarget.dataset.url;
        const ITEM_STATUS = e.currentTarget.checked;

        $.ajax({
            type: 'PUT',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: ITEM_URL + '/' + ITEM_ID + ' /change-status',
            dataType: 'json',
            data: {
                id: ITEM_ID,
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

    $('.delete-usuario, .delete-materia, .delete-archivo').on('click', (e) => {

        const ITEM_ID = e.currentTarget.dataset.id;
        const ITEM_URL = e.currentTarget.dataset.url;
        const ITEM_NAME = e.currentTarget.dataset.name;

        modal.show();

        var title = confirmDialog.querySelector('.modal-title');
        var msg = confirmDialog.querySelector('.modal-msg');
        title.textContent = 'Eliminar';
        msg.textContent = '¿Estas seguro que desea eliminar "' + ITEM_NAME + '"?'

        confirmBtn = document.getElementById('confirmBtn');
        confirmBtn.dataset.id = ITEM_ID;
        confirmBtn.dataset.url = ITEM_URL;
    });


    $('#confirmBtn').on('click', (e) => {
        modal.hide();

        const ITEM_ID = e.currentTarget.dataset.id;
        const ITEM_URL = e.currentTarget.dataset.url;

        $.ajax({
            type: 'DELETE',
            url: ITEM_URL + '/' + ITEM_ID,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: (data) => {
                showToast(data.success, TOAST_SUCCESS_TYPE);
                $('#rowItem' + ITEM_ID).remove();
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

    var toast = new bootstrap.Toast(toastElement);
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