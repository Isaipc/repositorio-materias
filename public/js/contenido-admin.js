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
/* harmony export */   "confirmDialog": () => (/* binding */ confirmDialog),
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
/*!*****************************************!*\
  !*** ./resources/js/contenido-admin.js ***!
  \*****************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _constants__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./constants */ "./resources/js/constants.js");
/* harmony import */ var _ui__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ui */ "./resources/js/ui.js");


var unidad_url = 'unidades-ajax';
var archivo_url = 'archivos-ajax';
var materia_id = document.getElementById('materiaId').value;
var itemModalElement = document.getElementById('itemModal');
var uploadFileModalElement = document.getElementById('uploadFileModal');
var itemModal = new bootstrap.Modal(itemModalElement);
var uploadFileModal = new bootstrap.Modal(uploadFileModalElement);
var dtOverrideGlobals = {
  language: _constants__WEBPACK_IMPORTED_MODULE_0__.dtLanguageOptions,
  paginate: true,
  processing: true,
  stateSave: true,
  responsive: {
    details: true
  },
  ajax: {
    url: "/".concat(unidad_url, "/").concat(materia_id),
    dataSrc: 'data'
  },
  columns: [{
    className: 'dt-control',
    orderable: false,
    data: null,
    defaultContent: ""
  }, {
    data: 'nombre'
  }, {
    data: null
  }, {
    data: null
  }],
  columnDefs: [{
    targets: 2,
    render: function render(data, type, row, meta) {
      return "<div class=\"form-check form-switch\">\n                    <input class=\"form-check-input change-status\" ".concat(data.estatus == 1 ? 'checked' : '', " \n                    data-row=\"").concat(meta.row, "\"\n                    type=\"checkbox\" role=\"switch\">\n                </div>");
    }
  }, {
    targets: -1,
    render: function render(data, type, row, meta) {
      return "<button class=\"btn btn-sm btn-primary edit-item has-tooltip\" data-row=\"".concat(meta.row, "\"\n                    data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Editar\">\n                    <i class=\"bi bi-pencil-fill\"></i>\n                </button>\n                <button class=\"btn btn-sm btn-danger delete-item has-tooltip\" data-row=\"").concat(meta.row, "\"\n                    data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Eliminar\">\n                    <i class=\"bi bi-trash-fill\"></i>\n                </button>\n                <button class=\"btn btn-sm btn-secondary upload-file has-tooltip\" data-bs-toggle=\"tooltip\"  data-row=\"").concat(meta.row, "\" data-bs-placement=\"top\" title=\"Subir archivo\">\n                    <i class=\"bi bi-upload\"></i>\n                </button>\n                <a href=\"/archivos/").concat(data.id, "/eliminados\" class=\"btn btn-sm btn-secondary has-tooltip\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Archivos eliminados\">\n                    <i class=\"bi bi-trash\"></i>\n                </a>\n                ");
    }
  }]
};
var table = $('#table').DataTable(dtOverrideGlobals);
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
$('.add-item').on('click', function () {
  $('#unidadForm')[0].reset();
  $('#id').val(0);
  itemModalElement.querySelector('.modal-title').textContent = 'Agregar unidad';
});
$('#table tbody').on('change', '.change-status', function () {
  var data = table.row(this.dataset.row).data();
  var ITEM_STATUS = this.checked;
  $.ajax({
    type: 'PUT',
    url: "/unidades-ajax/".concat(data.id, "/change-status"),
    dataType: 'json',
    data: {
      id: data.id,
      estatus: ITEM_STATUS
    },
    success: function success(data) {
      (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(data.success, 'success');
      table.ajax.reload();
    },
    error: function error(jqXHR, textStatus, errorThrown) {
      (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(jqXHR.responseJSON.error, 'error');
    }
  });
});
$('#table').on('click', 'tbody .edit-item', function () {
  var data = table.row(this.dataset.row).data();
  itemModal.show();
  $('#id').val(data.id);
  $('#nombre').val(data.nombre);
  $('#estatus').prop('checked', (0,_ui__WEBPACK_IMPORTED_MODULE_1__.getSwitchStatus)(data.estatus));
  itemModalElement.querySelector('.modal-title').textContent = 'Editar unidad';
});
$('#table').on('click', 'tbody .delete-item', function () {
  var data = table.row(this.dataset.row).data();
  var request_url = "/".concat(unidad_url, "/").concat(data.id, "/archive");
  var request_type = 'DELETE';
  var title = 'Archivar';
  var item = data.nombre;
  (0,_ui__WEBPACK_IMPORTED_MODULE_1__.confirmDialog)(title, item, 'confirmArchive', function (confirm) {
    if (confirm) $.ajax({
      type: request_type,
      url: request_url,
      success: function success(data) {
        (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(data.success, 'success');
        table.ajax.reload();
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(jqXHR.responseJSON.error, 'error');
      }
    });
  });
});
$('#table').on('click', 'tbody .upload-file', function () {
  var data = table.row(this.dataset.row).data();
  $('#unidadId').val(data.id);
  $('#fileId').val(0);
  uploadFileModal.show();
  uploadFileModalElement.querySelector('.modal-title').textContent = 'Subir archivo';
});
$('#table tbody').on('change', '.change-status-file', function () {
  var ITEM_STATUS = this.checked;
  $.ajax({
    type: 'PUT',
    url: "/".concat(archivo_url, "/").concat(this.dataset.id, "/change-status"),
    dataType: 'json',
    data: {
      id: this.dataset.id,
      estatus: ITEM_STATUS
    },
    success: function success(data) {
      (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(data.success, 'success');
      table.ajax.reload();
    },
    error: function error(jqXHR, textStatus, errorThrown) {
      (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(jqXHR.responseJSON.error, 'error');
    }
  });
});
$('#table').on('click', 'tbody .edit-file', function () {
  var data = table.row(this.dataset.row).data();
  uploadFileModal.show();
  $('#fileId').val(this.dataset.id);
  $('#fileName').val(this.dataset.nombre);
  $('#unidadId').val(this.dataset.unidad);
  uploadFileModalElement.querySelector('.modal-title').textContent = 'Editar archivo';
});
$('#table').on('click', 'tbody .delete-file', function () {
  var request_url = "/".concat(archivo_url, "/").concat(this.dataset.id, "/archive");
  var request_type = 'DELETE';
  var title = 'Archivar';
  var item = this.dataset.nombre;
  (0,_ui__WEBPACK_IMPORTED_MODULE_1__.confirmDialog)(title, item, 'confirmArchive', function (confirm) {
    if (confirm) $.ajax({
      type: request_type,
      url: request_url,
      success: function success(data) {
        (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(data.success, 'success');
        table.ajax.reload();
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(jqXHR.responseJSON.error, 'error');
      }
    });
  });
});
$('#unidadForm').on('submit', function (e) {
  var form = $('#unidadForm');
  var data = form.serialize();
  var id = $('#id');
  var request_url = '/unidades-ajax';
  var request_type = 'POST';

  if (id.val() != 0) {
    request_url = "/unidades-ajax/".concat(id.val());
    request_type = 'PUT';
  }

  $.ajax({
    type: request_type,
    url: request_url,
    dataType: 'json',
    data: data,
    success: function success(data) {
      (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(data.success, 'success');
      itemModal.hide();
      form[0].reset();
      table.ajax.reload();
    },
    error: function error(jqXHR, textStatus, errorThrown) {
      (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(jqXHR.responseJSON.error, 'error');
    }
  });
});
$('#fileUploadForm').on('submit', function (e) {
  e.preventDefault();
  var form = document.getElementById('fileUploadForm');
  var id = document.getElementById('fileId').value;
  var file = document.getElementById('file').files[0];
  var unidadId = document.getElementById('unidadId').value;
  var nombre = document.getElementById('fileName').value;
  var formData = new FormData();
  formData.append('id', id);
  formData.append('unidad_id', unidadId);
  formData.append('file', file);
  formData.append('nombre', nombre);
  var request_type = 'POST';
  var request_url = "/".concat(archivo_url);

  if (id != 0) {
    request_url = "/".concat(archivo_url, "/").concat(id);
    formData.append('_method', 'PUT');
  }

  $.ajax({
    type: request_type,
    url: request_url,
    processData: false,
    contentType: false,
    // dataType: 'json',
    data: formData,
    success: function success(data) {
      (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(data.success, 'success');
      uploadFileModal.hide();
      $(form)[0].reset();
      table.ajax.reload();
    },
    error: function error(jqXHR, textStatus, errorThrown) {
      (0,_ui__WEBPACK_IMPORTED_MODULE_1__.showToast)(jqXHR.responseJSON.error, 'error');
    }
  });
});
$('#file').on('change', function () {
  $('#fileName').val(this.files[0].name);
});

function format(data) {
  if (data.archivos.length == 0) return "<span class=\"text-muted\">No hay archivos disponibles</span>";
  var result = data.archivos.reduce(function (acc, e) {
    return acc + "<tr>\n                <td></td>    \n                <td>    \n                    <a href=\"/archivos/".concat(e.id, "/").concat(e.nombre, "\" class=\"text-decoration-none has-tooltip\" \n                    data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Mostrar detalles\"\n                    target=\"_blank\" rel=\"noopener noreferrer\">\n                    <i class=\"bi bi-filetype-").concat(e.extension, "\" style=\"font-size: 1.2rem;\"></i>\n                    ").concat(e.nombre, "\n                    </a>\n                </td>\n                <td>\n                    <div class=\"form-check form-switch\">\n                        <input class=\"form-check-input change-status-file\" ").concat(e.estatus == 1 ? 'checked' : '', " \n                        data-id=\"").concat(e.id, "\"\n                        type=\"checkbox\" role=\"switch\">\n                    </div>\n                </td>\n                <td>\n                    <button class=\"btn btn-sm btn-primary edit-file has-tooltip\" \n                        data-id=\"").concat(e.id, "\" data-nombre=\"").concat(e.nombre, "\"\n                        data-unidad=\"").concat(data.id, "\"\n                        data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Editar\">\n                        <i class=\"bi bi-pencil-fill\"></i>\n                    </button>\n                    <button class=\"btn btn-sm btn-danger delete-file has-tooltip\" \n                        data-id=\"").concat(e.id, "\" data-nombre=\"").concat(e.nombre, "\"\n                        data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Eliminar\">\n                        <i class=\"bi bi-trash-fill\"></i>\n                    </button>\n            </td>\n        </tr>");
  }, '');
  return $(result).toArray();
}

new bootstrap.Tooltip(document.body, {
  selector: '.has-tooltip'
});
})();

/******/ })()
;