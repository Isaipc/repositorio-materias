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
/* harmony export */   "dtOverrideGlobals": () => (/* binding */ dtOverrideGlobals)
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
/* harmony export */   "TOAST_ERROR_TYPE": () => (/* binding */ TOAST_ERROR_TYPE),
/* harmony export */   "TOAST_SUCCESS_TYPE": () => (/* binding */ TOAST_SUCCESS_TYPE),
/* harmony export */   "confirmDialog": () => (/* binding */ confirmDialog),
/* harmony export */   "generateRandomKey": () => (/* binding */ generateRandomKey),
/* harmony export */   "getSwitchStatus": () => (/* binding */ getSwitchStatus),
/* harmony export */   "showToast": () => (/* binding */ showToast)
/* harmony export */ });
var STATUS_ENABLED = 1;
var STATUS_DISABLED = 2;
var TOAST_ERROR_TYPE = 1;
var TOAST_SUCCESS_TYPE = 0;
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

var getConfirmBody = function getConfirmBody(confirmType, item) {
  var _confirmation_type$co, _confirmation_type$co2;

  return (_confirmation_type$co = (_confirmation_type$co2 = confirmation_type[confirmType]) === null || _confirmation_type$co2 === void 0 ? void 0 : _confirmation_type$co2.call(confirmation_type, item)) !== null && _confirmation_type$co !== void 0 ? _confirmation_type$co : 'Función no encontrada';
};

var confirmationModalElement = document.getElementById('confirmationModal');
var confirmationTitle = confirmationModalElement.querySelector('.modal-title');
var confirmationBody = confirmationModalElement.querySelector('.modal-body');
var confirmationModal = new bootstrap.Modal(confirmationModalElement);
var toastElement = document.getElementById('toast');

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

var showToast = function showToast(msg, type) {
  var toastElHeader = toastElement.querySelector('.toast-header');
  var toastElTitle = toastElement.querySelector('.toast-title');
  var toastElBody = toastElement.querySelector('.toast-body');

  switch (type) {
    case TOAST_SUCCESS_TYPE:
      toastElHeader.classList.remove('bg-danger');
      toastElHeader.classList.add('bg-success');
      toastElTitle.textContent = 'Completado';
      break;

    case TOAST_ERROR_TYPE:
      toastElHeader.classList.remove('bg-success');
      toastElHeader.classList.add('bg-danger');
      toastElTitle.textContent = 'Error';
      break;
  }

  toastElBody.textContent = msg;
  var toast = bootstrap.Toast.getInstance(toastElement);
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
/*!******************************************!*\
  !*** ./resources/js/contenido-alumno.js ***!
  \******************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./constants */ "./resources/js/constants.js");
/* harmony import */ var _ui__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ui */ "./resources/js/ui.js");


var materia_id = document.getElementById('materiaId').value;
var table = $('#table').DataTable({
  language: _constants__WEBPACK_IMPORTED_MODULE_0__.dtLanguageOptions,
  paginate: true,
  ajax: {
    url: "/unidades-ajax/".concat(materia_id),
    dataSrc: 'data'
  },
  columns: [{
    className: 'dt-control',
    orderable: false,
    data: null,
    defaultContent: ""
  }, {
    data: 'nombre'
  }]
});
$('#detachMateria').on('click', function () {
  var request_url = "/alumnos/materias/".concat(materia_id);
  var request_type = 'DELETE';
  var title = 'Dar de baja';
  var item = this.dataset.name;
  (0,_ui__WEBPACK_IMPORTED_MODULE_1__.confirmDialog)(title, item, 'confirmDetach', function (confirm) {
    if (confirm) $.ajax({
      url: request_url,
      type: request_type,
      success: function success(data) {
        (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(data.success, _ui__WEBPACK_IMPORTED_MODULE_1__.TOAST_SUCCESS_TYPE);
        setTimeout(function () {
          window.location.href = "/";
        }, 5000);
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(jqXHR.responseJSON.error, _ui__WEBPACK_IMPORTED_MODULE_1__.TOAST_ERROR_TYPE);
      }
    });
  });
});
$('#table').on('requestChild.dt', function (e, row) {
  var data = row.data();
  row.child(format(data)).show();
});
$('#table').on('click', 'tbody td.dt-control', function () {
  var tr = $(this).closest('tr');
  var row = table.row(tr);
  if (row.child.isShown()) row.child.hide();else {
    row.child(format(row.data())).show();
  }
});

function format(data) {
  var rowItems = '';
  if (data.archivos.length == 0) return "<span class=\"text-muted\">No hay archivos disponibles</span>";
  data.archivos.forEach(function (e) {
    rowItems += "<tr>\n                <td></td>    \n                <td>    \n                    <a href=\"/archivos/".concat(e.id, "\" class=\"text-decoration-none has-tooltip\" \n                    data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Mostrar detalles\"\n                    target=\"_blank\" rel=\"noopener noreferrer\">\n                    <i class=\"bi bi-filetype-").concat(e.extension, "\" style=\"font-size: 1.5rem;\"></i>\n                    ").concat(e.nombre, "\n                    </a>\n                </td>\n            </tr>");
  });
  return $(rowItems).toArray();
}
})();

/******/ })()
;