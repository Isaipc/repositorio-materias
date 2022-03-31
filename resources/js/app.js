/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

$ = require('jquery');
require('jquery-validation');
require('./bootstrap');
require('bootstrap-select');
require('bootstrap-icons/font/bootstrap-icons');
// require('datatables.net-responsive-bs4');
require('datatables.net-bs4');

const qntYears = 10;
const dayNames = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
const daysOfWeek = ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'];
const monthNames = [
    'Enero',
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Setiembre',
    'Octubre',
    'Noviembre',
    'Diciembre'
];

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

$('.data-row').click((e) => {
    e.currentTarget.classList.toggle('table-active');
});

