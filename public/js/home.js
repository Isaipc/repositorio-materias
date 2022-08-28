/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

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
/*!******************************!*\
  !*** ./resources/js/home.js ***!
  \******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _ui__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ui */ "./resources/js/ui.js");

var claveModalElement = document.getElementById('claveModal');
var claveModal = new bootstrap.Modal(claveModalElement);
$('#assignMateria').on('click', function () {
  return claveModal.show();
});
$('#form').on('submit', function (e) {
  e.preventDefault();
  var form = $('#form');
  var data = form.serialize();
  $.ajax({
    type: 'POST',
    url: '/claves-materia',
    dataType: 'json',
    data: data,
    success: function success(data) {
      (0,_ui__WEBPACK_IMPORTED_MODULE_0__.showToast)(data.success, 'success');
      claveModal.hide();
      form[0].reset();
      setTimeout(function () {
        return window.location.href = "/";
      }, 3000);
    },
    error: function error(jqXHR, textStatus, errorThrown) {
      (0,_ui__WEBPACK_IMPORTED_MODULE_0__.showToast)(jqXHR.responseJSON.message, 'error');
    }
  });
});
})();

/******/ })()
;