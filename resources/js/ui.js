const STATUS_ENABLED = 1;
const STATUS_DISABLED = 2;
const TOAST_ERROR_TYPE = 1;
const TOAST_SUCCESS_TYPE = 0;
const defaultButtons = ['Cancelar', 'Aceptar']
const default_message = '¿Ejecutar acción?'
const default_title = 'Acción'
const confirmation_type = {
    confirmArchive: (itemName) =>
        `<div>
            <i class="bi bi-exclamation-diamond-fill" style="font-size: 2.5rem; color: orange;"></i>
        </div>
        ¿Desea eliminar <span class='text-danger'>${itemName}</span>?`,
    confirmRestore: (itemName) =>
        `<div>
            <i class="bi bi-exclamation-diamond-fill" style="font-size: 2.5rem; color: orange;"></i>
        </div>
        ¿Estas seguro que desea restaurar <span class='text-danger'>${itemName}</span>?`,
    confirmDelete: (itemName) =>
        `<div>
            <i class="bi bi-exclamation-circle-fill" style="font-size: 2.5rem; color: red;"></i>
        </div>
        ¿Desea eliminar permanentemente <span class='text-danger'>${itemName}</span>? 
        Esta acción no se puede deshacer.`
}

const getConfirmBody = (confirmType, item) => {
    return confirmation_type[confirmType]?.(item) ?? 'Función no encontrada'
}

const confirmationModalElement = document.getElementById('confirmationModal')
const confirmationTitle = confirmationModalElement.querySelector('.modal-title')
const confirmationBody = confirmationModalElement.querySelector('.modal-body')
const okButton = document.getElementById('okBtn')
const cancelButton = document.getElementById('cancelBtn')

const confirmationModal = new bootstrap.Modal(confirmationModalElement, {
    keyboard: true
});

const toastElement = document.getElementById('toast');

const confirmDialog = (title, item, type, callback) => {
    confirmationTitle.textContent = title
    confirmationBody.innerHTML = getConfirmBody(type, item)

    confirmationModal.show()
    cancelButton.addEventListener('click', () => {
        callback(false)
        confirmationModal.hide()
    })

    okButton.addEventListener('click', () => {
        callback(true)
        confirmationModal.hide()
    })

    confirmationModalElement.addEventListener('hide.bs.modal', event => callback(false))
}

const showToast = (msg, type) => {
    const toastElHeader = toastElement.querySelector('.toast-header');
    const toastElTitle = toastElement.querySelector('.toast-title');
    const toastElBody = toastElement.querySelector('.toast-body');
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

    const toast = bootstrap.Toast.getInstance(toastElement);
    toast.show();
}

const getSwitchStatus = (status) => {
    return status == STATUS_ENABLED;
}

const generateRandomKey = (length = 5) => {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
}
export {
    confirmDialog,
    getSwitchStatus,
    generateRandomKey,
    showToast,
    TOAST_ERROR_TYPE,
    TOAST_SUCCESS_TYPE,
    STATUS_DISABLED,
    STATUS_ENABLED
}