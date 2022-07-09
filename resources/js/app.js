/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('jquery-validation');
require('./bootstrap');
require('bootstrap-select');
require('bootstrap-icons/font/bootstrap-icons');
require('datatables.net-bs5');
require('datatables.net-responsive-bs5');

import {
    HUMAN_FORMAT,
    TIMESTAMP_FORMAT,
    OUTPUT_DATE_FORMAT,
    DEFAULT_FORMAT
} from './constants'

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
    const dropdown = new bootstrap.Dropdown(dropdownToggleEl)
    return dropdown;
});

// initialize all tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});

new bootstrap.Tooltip(document.body, { selector: '.has-tooltip' });

var dateFormats = [
    HUMAN_FORMAT,
    TIMESTAMP_FORMAT,
    OUTPUT_DATE_FORMAT,
    DEFAULT_FORMAT
];

var currentDateFormat = 0;


$(function () {
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

const formatDateForHumans = (date) => _moment(date).fromNow()
const formatDateTo = (date) => _moment(date).format(dateFormats[currentDateFormat])
