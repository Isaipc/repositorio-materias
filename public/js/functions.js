STATUS_ENABLED = 1;
STATUS_DISABLED = 2;

TOAST_ERROR_TYPE = 1;
TOAST_SUCCESS_TYPE = 0;

const dtLanguageOptions = {
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

function showToast(msg, type) {

    var toastElement = document.getElementById('toast');
    var toastElementHeader = toastElement.querySelector('.toast-header');
    var toastElementTitle = toastElement.querySelector('.toast-title');
    var toastElementBody = toastElement.querySelector('.toast-body');
    switch (type) {
        case TOAST_SUCCESS_TYPE:
            toastElementHeader.classList.remove('bg-danger');
            toastElementHeader.classList.add('bg-success');
            toastElementTitle.textContent = 'Completado';
            break;
        case TOAST_ERROR_TYPE:
            toastElementHeader.classList.remove('bg-success');
            toastElementHeader.classList.add('bg-danger');
            toastElementTitle.textContent = 'Error';
            break;
    }
    toastElementBody.textContent = msg;

    var toast = bootstrap.Toast.getInstance(toastElement);
    toast.show();
}

function getSwitchStatus(status) {
    return status == STATUS_ENABLED;
}

function generateRandomKey(length = 5) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
}