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

const dateFormat = 'DD/MM/YYYY';
var today = new Date();

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

$(function () {
    _moment.locale('es');
    moment = _moment;
});

