/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/constants.js":
/*!***********************************!*\
  !*** ./resources/js/constants.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "DEFAULT_FORMAT": () => (/* binding */ DEFAULT_FORMAT),
/* harmony export */   "HUMAN_FORMAT": () => (/* binding */ HUMAN_FORMAT),
/* harmony export */   "OUTPUT_DATE_FORMAT": () => (/* binding */ OUTPUT_DATE_FORMAT),
/* harmony export */   "TIMESTAMP_FORMAT": () => (/* binding */ TIMESTAMP_FORMAT),
/* harmony export */   "dtLanguageOptions": () => (/* binding */ dtLanguageOptions),
/* harmony export */   "dtOverrideGlobals": () => (/* binding */ dtOverrideGlobals),
/* harmony export */   "status_default_error": () => (/* binding */ status_default_error),
/* harmony export */   "status_server_error": () => (/* binding */ status_server_error),
/* harmony export */   "status_unprocessable_entity": () => (/* binding */ status_unprocessable_entity)
/* harmony export */ });
var HUMAN_FORMAT = null;
var TIMESTAMP_FORMAT = 'DD/MM/YYYY h:m A';
var OUTPUT_DATE_FORMAT = 'dddd DD/MMM/YYYY';
var DEFAULT_FORMAT = 'YYYY-MM-DD hh:mm:ss A';
var dtLanguageOptions = {
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
var dtOverrideGlobals = {
  language: dtLanguageOptions,
  paginate: true,
  processing: true
};
var status_unprocessable_entity = 422;
var status_server_error = 500;
var status_default_error = 400;

/***/ }),

/***/ "./resources/js/ui.js":
/*!****************************!*\
  !*** ./resources/js/ui.js ***!
  \****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "STATUS_DISABLED": () => (/* binding */ STATUS_DISABLED),
/* harmony export */   "STATUS_ENABLED": () => (/* binding */ STATUS_ENABLED),
/* harmony export */   "confirmDialog": () => (/* binding */ confirmDialog),
/* harmony export */   "defaultButtons": () => (/* binding */ defaultButtons),
/* harmony export */   "default_message": () => (/* binding */ default_message),
/* harmony export */   "default_title": () => (/* binding */ default_title),
/* harmony export */   "generateRandomKey": () => (/* binding */ generateRandomKey),
/* harmony export */   "getSwitchStatus": () => (/* binding */ getSwitchStatus),
/* harmony export */   "showToast": () => (/* binding */ showToast)
/* harmony export */ });
var STATUS_ENABLED = 1;
var STATUS_DISABLED = 2;
var defaultButtons = ['Cancelar', 'Aceptar'];
var default_message = '¿Ejecutar acción?';
var default_title = 'Acción';
var confirmation_type = {
  confirmArchive: function confirmArchive(itemName) {
    return "<div>\n            <i class=\"bi bi-exclamation-diamond-fill\" style=\"font-size: 2.5rem; color: orange;\"></i>\n        </div>\n        \xBFDesea eliminar <span class='text-danger'>".concat(itemName, "</span>?");
  },
  confirmRestore: function confirmRestore(itemName) {
    return "<div>\n            <i class=\"bi bi-exclamation-diamond-fill\" style=\"font-size: 2.5rem; color: orange;\"></i>\n        </div>\n        \xBFEstas seguro que desea restaurar <span class='text-danger'>".concat(itemName, "</span>?");
  },
  confirmDelete: function confirmDelete(itemName) {
    return "<div>\n            <i class=\"bi bi-exclamation-circle-fill\" style=\"font-size: 2.5rem; color: red;\"></i>\n        </div>\n        \xBFDesea eliminar permanentemente <span class='text-danger'>".concat(itemName, "</span>? \n        Esta acci\xF3n no se puede deshacer.");
  },
  confirmDetach: function confirmDetach(itemName) {
    return "<div>\n            <i class=\"bi bi-exclamation-circle-fill\" style=\"font-size: 2.5rem; color: red;\"></i>\n        </div>\n        \xBFDesea darse de baja en <span class='text-danger'>".concat(itemName, "</span>?");
  }
};
var toast_type = {
  success: function success() {
    toastElHeader.classList.add('bg-success');
    toastElTitle.textContent = 'Completado';
  },
  error: function error() {
    toastElHeader.classList.add('bg-success');
    toastElTitle.textContent = 'Error';
  },
  "default": function _default() {
    toastElHeader.classList.add('bg-primary');
    toastElTitle.textContent = 'Aviso';
  }
};

var getConfirmBody = function getConfirmBody(confirmType, item) {
  var _confirmation_type$co, _confirmation_type$co2;

  return (_confirmation_type$co = (_confirmation_type$co2 = confirmation_type[confirmType]) === null || _confirmation_type$co2 === void 0 ? void 0 : _confirmation_type$co2.call(confirmation_type, item)) !== null && _confirmation_type$co !== void 0 ? _confirmation_type$co : 'Función no encontrada';
};

var toastElement = document.getElementById('toast');
var toastElHeader = toastElement.querySelector('.toast-header');
var toastElTitle = toastElement.querySelector('.toast-title');
var toastElBody = toastElement.querySelector('.toast-body');
var toast = bootstrap.Toast.getInstance(toastElement);
var confirmationModalElement = document.getElementById('confirmationModal');
var confirmationTitle = confirmationModalElement.querySelector('.modal-title');
var confirmationBody = confirmationModalElement.querySelector('.modal-body');
var confirmationModal = new bootstrap.Modal(confirmationModalElement);
var confirmDialog = function confirmDialog(title, item, type, callback) {
  var okButton = document.getElementById('okBtn');
  var cancelButton = document.getElementById('cancelBtn');
  confirmationTitle.textContent = title;
  confirmationBody.innerHTML = getConfirmBody(type, item);
  confirmationModal.show();
  cancelButton.addEventListener('click', function () {
    callback(false);
    confirmationModal.hide();
  });
  okButton.addEventListener('click', function () {
    callback(true);
    confirmationModal.hide();
  });
  confirmationModalElement.addEventListener('hide.bs.modal', function (event) {
    $('#okBtn').replaceWith($('#okBtn').clone());
    $('#cancelBtn').replaceWith($('#cancelBtn').clone());
  });
};
var showToast = function showToast(msg) {
  var _toast_type$toastType;

  var toastType = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'default';
  toastElHeader.classList.remove('bg-primary');
  toastElHeader.classList.remove('bg-success');
  toastElHeader.classList.remove('bg-danger');
  (_toast_type$toastType = toast_type[toastType]) === null || _toast_type$toastType === void 0 ? void 0 : _toast_type$toastType.call(toast_type);
  toastElBody.textContent = msg;
  toast.show();
};
var getSwitchStatus = function getSwitchStatus(status) {
  return status == STATUS_ENABLED;
};
var generateRandomKey = function generateRandomKey() {
  var length = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 5;
  var result = '';
  var characters = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz0123456789';
  var charactersLength = characters.length;

  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }

  return result;
};

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!**********************************!*\
  !*** ./resources/js/materias.js ***!
  \**********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ui__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ui */ "./resources/js/ui.js");
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./constants */ "./resources/js/constants.js");


var base_url = 'materias-ajax';
var materiaModalElement = document.getElementById('materiaModal');
var materiaModal = new bootstrap.Modal(materiaModalElement, {
  keyboard: true
});
var materiaForm = document.getElementById('materiaForm');

var _error = document.getElementById('error');

var nombre = document.getElementById('nombre');
var clave = document.getElementById('clave');
var nombreInvalidFeedback = document.getElementById('nombreInvalidFeedback');
var claveInvalidFeedback = document.getElementById('claveInvalidFeedback');
var dtOverrideGlobals = {
  language: _.dtLanguageOptions,
  paginate: true,
  processing: true,
  responsive: {
    details: true
  },
  ajax: {
    url: "/".concat(base_url),
    dataSrc: 'data'
  },
  columns: [{
    data: null
  }, {
    data: null
  }, {
    data: 'clave'
  }, {
    data: null
  }],
  columnDefs: [{
    targets: 0,
    render: function render(data, type, row, meta) {
      return "".concat(data.nombre, "\n            <a href=\"/materias/").concat(data.id, "\" class=\"btn btn-link has-tooltip\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Mostrar detalles\">\n                <i class=\"bi bi-box-arrow-up-right\"></i>\n            </a>");
    }
  }, {
    targets: 1,
    render: function render(data, type, row, meta) {
      return "<div class=\"form-check form-switch\">\n                <input class=\"form-check-input change-status\" ".concat(data.estatus == 1 ? 'checked' : '', " type=\"checkbox\" role=\"switch\"\n                    data-row=\"").concat(meta.row, "\">\n            </div>");
    }
  }, {
    targets: 2,
    render: function render(data, type, row, meta) {
      return "<span class=\"alert alert-primary px-2 py-0\">".concat(data, "</span>");
    }
  }, {
    targets: -1,
    render: function render(data, type, row, meta) {
      return "<div>\n                <button class=\"btn btn-sm btn-primary edit-item has-tooltip\"\n                    data-row=\"".concat(meta.row, "\"\n                    data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Editar\">\n                    <i class=\"bi bi-pencil-fill\"></i>\n                </button>\n                <button class=\"btn btn-sm btn-danger delete-item has-tooltip\"\n                    data-row=\"").concat(meta.row, "\"\n                    data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Eliminar\">\n                    <i class=\"bi bi-trash-fill\"></i>\n                </button>\n                <a href=\"/materias/").concat(data.id, "/unidades\" class=\"btn btn-sm btn-light has-tooltip\" data-bs-toggle=\"tooltip\"\n                    data-bs-placement=\"top\" title=\"Mostrar contenido\">\n                    <i class=\"bi bi-file-earmark-fill\"></i>\n                </a>\n                <a href=\"/materias/").concat(data.id, "/alumnos\" class=\"btn btn-sm btn-light has-tooltip\" data-bs-toggle=\"tooltip\"\n                    data-bs-placement=\"top\" title=\"Mostrar alumnos\">\n                    <i class=\"bi bi-people-fill\"></i>\n                </a>\n            </div>");
    }
  }]
};
var table = $('#table').DataTable(dtOverrideGlobals);
$('#addMateria').on('click', function () {
  materiaModal.show();
  materiaForm.reset();
  materiaForm.classList.remove('was-validated');

  _error.classList.add('d-none');

  removeValidationStyles(nombre);
  removeValidationStyles(clave);
  $('#materiaId').val(0);
  $('#clave').val(_ui__WEBPACK_IMPORTED_MODULE_0__.generateRandomKey());
  materiaModalElement.querySelector('.modal-title').textContent = 'Agregar materia';
});

var removeValidationStyles = function removeValidationStyles(inputEl) {
  return inputEl.classList.remove('is-invalid', 'is-valid');
};

nombre.addEventListener('keydown', function () {
  return removeValidationStyles(nombre);
});
clave.addEventListener('keydown', function () {
  return removeValidationStyles(clave);
});
materiaForm.addEventListener('submit', function (e) {
  e.preventDefault();
  e.stopPropagation();
  var form = $('#materiaForm');
  var data = form.serialize();
  var id = $('#materiaId');
  var url = '/materias-ajax';
  var type = 'POST';

  if (id.val() != 0) {
    url = "/materias-ajax/".concat(id.val());
    type = 'PUT';
  }

  $.ajax({
    type: type,
    url: url,
    dataType: 'json',
    data: data,
    success: function success(data) {
      _ui__WEBPACK_IMPORTED_MODULE_0__.showToast(data.success, 'success');
      materiaModal.hide();
      form[0].reset();
      materiaForm.classList.add('was-validated');
      table.ajax.reload();
    },
    error: function error(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseJSON.message);

      if (jqXHR.status == _constants__WEBPACK_IMPORTED_MODULE_1__.status_unprocessable_entity) {
        var errors = jqXHR.responseJSON.errors;

        if (errors.nombre) {
          nombre.classList.remove('is-valid');
          nombre.classList.add('is-invalid');
          nombreInvalidFeedback.innerHTML = errors.nombre.map(function (e) {
            return "<li>".concat(e, "</li>");
          });
        }

        if (errors.clave) {
          clave.classList.remove('is-valid');
          clave.classList.add('is-invalid');
          claveInvalidFeedback.innerHTML = errors.clave.map(function (e) {
            return "<li>".concat(e, "</li>");
          });
        }
      }

      if (jqXHR.status == _constants__WEBPACK_IMPORTED_MODULE_1__.status_server_error) {
        _error.innerHTML = jqXHR.responseJSON.error;

        _error.classList.remove('d-none');
      }
    }
  });
}, false);
$('#table').on('click', 'tbody .edit-item', function () {
  var data = table.row(this.dataset.row).data();
  materiaModal.show();
  materiaForm.classList.remove('was-validated');
  $('#materiaId').val(data.id);
  $('#nombre').val(data.nombre);
  $('#estatus').prop('checked', _ui__WEBPACK_IMPORTED_MODULE_0__.getSwitchStatus(data.estatus));
  $('#clave').val(data.clave);
  materiaModalElement.querySelector('.modal-title').textContent = 'Editar materia';
});
$('#table').on('click', 'tbody .delete-item', function () {
  var data = table.row(this.dataset.row).data();
  var request_url = "/materias-ajax/".concat(data.id, "/archive");
  var request_type = 'DELETE';
  var title = 'Archivar';
  var item = data.nombre;
  _ui__WEBPACK_IMPORTED_MODULE_0__.confirmDialog(title, item, 'confirmArchive', function (confirm) {
    if (confirm) $.ajax({
      type: request_type,
      url: request_url,
      success: function success(data) {
        _ui__WEBPACK_IMPORTED_MODULE_0__.showToast(data.success, 'success');
        table.ajax.reload();
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        _ui__WEBPACK_IMPORTED_MODULE_0__.showToast(jqXHR.responseJSON.error, 'error');
      }
    });
  });
});
$('#buttonRandomKey').on('click', function () {
  $('#clave').val(_ui__WEBPACK_IMPORTED_MODULE_0__.generateRandomKey());
});
$('#table tbody').on('change', '.change-status', function () {
  var data = table.row(this.dataset.row).data();
  var ITEM_STATUS = this.checked;
  $.ajax({
    type: 'PUT',
    url: "/".concat(base_url, "/").concat(data.id, "/change-status"),
    dataType: 'json',
    data: {
      id: data.id,
      estatus: ITEM_STATUS
    },
    success: function success(data) {
      _ui__WEBPACK_IMPORTED_MODULE_0__.showToast(data.success, 'success');
      table.ajax.reload();
    },
    error: function error(jqXHR, textStatus, errorThrown) {
      _ui__WEBPACK_IMPORTED_MODULE_0__.showToast(jqXHR.responseJSON.error, 'error');
    }
  });
});
})();

/******/ })()
;