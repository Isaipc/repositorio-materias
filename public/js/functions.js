TOAST_ERROR_TYPE = 1;
TOAST_SUCCESS_TYPE = 0;

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