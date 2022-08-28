/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./resources/js/alumnos.js ***!
  \*********************************/
var base_url = 'usuarios';
var userModalElement = document.getElementById('userModal');
var userModal = new bootstrap.Modal(userModalElement, {
  keyboard: true
});
var dtOverrideGlobals = {
  language: dtLanguageOptions,
  paginate: true,
  processing: true,
  responsive: true,
  ajax: {
    url: "/".concat(base_url, "/list"),
    dataSrc: 'data'
  },
  columns: [{
    data: null
  }, {
    data: 'nombre'
  }, {
    data: 'email'
  }, {
    data: 'username'
  }, {
    data: 'materias'
  }, {
    data: null
  }],
  columnDefs: [{
    targets: 0,
    render: function render(data, type, row, meta) {
      return "<a href=\"/usuarios/".concat(data.id, "\" class=\"btn btn-link\" data-bs-toggle=\"tooltip\"\n                data-bs-placement=\"top\" title=\"Mostrar detalles\">\n                    <i class=\"bi bi-box-arrow-up-right\"></i>\n            </a>");
    }
  }, {
    targets: 4,
    render: function render(data, type, row, meta) {
      var renderHTML = '';

      if (data.length > 0) {
        data.forEach(function (e) {
          renderHTML += "<li>\n                                    <a href=\"/materias/".concat(e.id, "\" class=\"btn btn-link text-decoration-none\"> \n                                            ").concat(e.nombre, "\n                                            </a>\n                                            </li>");
        });
      } else {
        renderHTML = "<span class=\"text-muted\">Sin materias</span>";
      }

      return renderHTML;
    }
  }, {
    targets: -1,
    render: function render(data, type, row, meta) {
      return "<a href=\"/usuarios/".concat(data.id, "/editar\" class=\"btn btn-sm btn-primary has-tooltip\" \n            data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Editar\"> \n            <i class=\"bi bi-pencil-fill\"></i></a>\n            <button class=\"btn btn-sm btn-danger delete-item has-tooltip\" \n            data-row=\"").concat(meta.row, "\" data-bs-toggle=\"tooltip\" data-bs-placement=\"top\" title=\"Eliminar\">\n            <i class=\"bi bi-trash-fill\"></i></button>");
    }
  }]
};
var table = $('#table').DataTable(dtOverrideGlobals);
$('#addUser').on('click', function () {
  userModal.show();
  $('#userForm')[0].reset();
  $('#userId').val(0);
  userModalElement.querySelector('.modal-title').textContent = 'Nuevo alumno';
});
$('#userForm').on('submit', function (e) {
  var form = $('#userForm');
  var data = form.serialize();
  var id = $('#userId');

  if (id.val() == 0) {
    url = '/usuarios';
    type = 'POST';
  }

  $.ajax({
    type: type,
    url: url,
    dataType: 'json',
    data: data,
    success: function success(data) {
      showToast(data.success, 'success');
      userModal.hide();
      form[0].reset();
      table.ajax.reload();
    },
    error: function error(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseJSON);
      showToast(jqXHR.responseJSON.errors.nombre, 'error');
    }
  });
});
$('#table').on('click', 'tbody .edit-item', function () {
  var data = table.row(this.dataset.row).data();
  userModal.show();
  $('#userId').val(data.id);
  $('#nombre').val(data.nombre);
  $('#username').val(data.username);
  $('#email').val(data.email);
  userModalElement.querySelector('.modal-title').textContent = 'Editar usuario';
});
$('#table').on('click', 'tbody .delete-item', function () {
  var data = table.row(this.dataset.row).data();
  var request_url = "/".concat(base_url, "/").concat(data.id, "/archive");
  var request_type = 'DELETE';
  var title = 'Archivar';
  var item = data.nombre;
  confirmDialog(title, item, 'confirmArchive', function (confirm) {
    if (confirm) $.ajax({
      type: request_type,
      url: request_url,
      success: function success(data) {
        showToast(data.success, 'success');
        table.ajax.reload();
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        showToast(jqXHR.responseJSON.error, 'error');
      }
    });
  });
});
/******/ })()
;