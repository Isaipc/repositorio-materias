/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('jquery-validation');
require('./bootstrap');
require('bootstrap-select');
require('bootstrap-icons/font/bootstrap-icons');
var _moment = require('moment');

require('datatables.net-bs5');
require('datatables.net-responsive-bs5');


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

new bootstrap.Tooltip(document.body, { selector: '.has-tooltip' });

const HUMAN_FORMAT = null;
const TIMESTAMP_FORMAT = 'DD/MM/YYYY h:m A'
const OUTPUT_DATE_FORMAT = 'dddd DD/MMM/YYYY'
const DEFAULT_FORMAT = 'YYYY-MM-DD hh:mm:ss A';

var dateFormats = [
    HUMAN_FORMAT,
    TIMESTAMP_FORMAT,
    OUTPUT_DATE_FORMAT,
    DEFAULT_FORMAT
];

var currentDateFormat = 0;


$(function () {
    _moment.locale('es');
    moment = _moment;
    
    $('.date-formatted').filter(function (index) {
        this.textContent = formatDateForHumans(this.dataset.value)
    })
    
    $('.toggle-date-format').on('click', () => {
        currentDateFormat = currentDateFormat >= dateFormats.length ? 0 : currentDateFormat;

        if (dateFormats[currentDateFormat] === null) {
            $('.date-formatted').filter(function (index) {
                this.textContent = formatDateForHumans(this.dataset.value)
            })
        } else {

            $('.date-formatted').filter(function (index) {
                this.textContent = formatDateTo(this.dataset.value)
            })

        }
        currentDateFormat++;
    })

});

function formatDateForHumans(date) {
    return moment(date).fromNow();
}

function formatDateTo(date) {
    return moment(date).format(dateFormats[currentDateFormat]);
}
