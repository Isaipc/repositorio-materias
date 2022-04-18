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

var today = new Date();

$(function ($) {

    // DataTables SETUP
    $('#datatable').DataTable({
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

    $('.change-status-materia').on('change', (e) => {
        var materia_id = e.currentTarget.getAttribute('data-id');

        $.ajax({
            type: 'PUT',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '/materias/' + materia_id + ' /change-status',
            dataType: 'json',
            data: {
                id: materia_id,
                estatus: e.currentTarget.checked
            },
            success: (data) => {
                showToastSuccess(data.success);
            },
            error: (jqXHR, textStatus, errorThrown) => {
                showToastError(jqXHR.responseJSON.error);
            }
        });

    });

    $('#confirmBtn').on('click', (e) => {
        confirmDialog = document.getElementById('confirmDialog');
        modal = bootstrap.Modal.getOrCreateInstance(confirmDialog);
        modal.hide();

        var materia_id = confirmBtn.getAttribute('data-id');

        $.ajax({
            type: 'DELETE',
            url: '/materias/' + materia_id,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: (data) => {
                showToastSuccess(data.success);
                $('#rowItem' + materia_id).remove();
            },
            error: (jqXHR, textStatus, errorThrown) => {
                showToastError(jqXHR.responseJSON.error);
            }
        });
    });

    $('.delete-materia').on('click', (e) => {
        var dataItem = $(e.currentTarget).data('item');

        confirmDialog = document.getElementById('confirmDialog');
        modal = bootstrap.Modal.getOrCreateInstance(confirmDialog);
        modal.show();

        var title = confirmDialog.querySelector('.modal-title');
        var msg = confirmDialog.querySelector('.modal-msg');
        title.textContent = 'Eliminar';
        msg.textContent = '¿Estas seguro que desea eliminar "' + dataItem.nombre + '"?'

        confirmBtn = document.getElementById('confirmBtn');
        confirmBtn.setAttribute('data-id', dataItem.id);
    });
});



function showToastSuccess(msg) {
    var toastElement = $('#toastSuccess');
    var toastElementBody = $('#toastSuccessBody');
    toastElementBody.html(msg);
    var toast = new bootstrap.Toast(toastElement);
    toast.show();
}

function showToastError(msg) {
    var toastElement = $('#toastError');
    var toastElementBody = $('#toastErrorBody');
    toastElementBody.html(msg);
    var toast = new bootstrap.Toast(toastElement);
    toast.show();
}



// INIT BOOTSTRAP COMPONENTS

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