/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

const { Toast } = require('bootstrap');

require('jquery-validation');
require('./bootstrap');
require('bootstrap-select');
require('bootstrap-icons/font/bootstrap-icons');
// require('datatables.net-responsive-bs4');
require('datatables.net-bs4');

require('datatables.net-bs5')

const dateFormat = 'DD/MM/YYYY';

var today = new Date();

$(
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
    })
);

// $('.data-row').click((e) => {
//     e.currentTarget.classList.toggle('table-active');
// });

$('.select-estatus').on('change', (e) => {
    estatus = e.currentTarget;
    changeEstatus(estatus.value);
});

function changeEstatus(estatus) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $.ajax({
        type: 'PUT',
        url: '/materias/{materia}',
        dataType: 'json',
        data: {
            materia: {
                estatus: estatus
            }
        },
        success: function () { 
            var toastElement = document.getElementById('toastSuccess')
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
        },
        error: function (e) {
            var toastElement = document.getElementById('toastError')
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    });

}

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