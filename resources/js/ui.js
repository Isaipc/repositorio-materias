const STATUS_ENABLED = 1;
const STATUS_DISABLED = 2;
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
        Esta acción no se puede deshacer.`,
    confirmDetach: (itemName) =>
        `<div>
            <i class="bi bi-exclamation-circle-fill" style="font-size: 2.5rem; color: red;"></i>
        </div>
        ¿Desea darse de baja en <span class='text-danger'>${itemName}</span>?`
}

const toast_type = {
    success: () => {
        toastElHeader.classList.add('bg-success')
        toastElTitle.textContent = 'Completado'
    },
    error: () => {
        toastElHeader.classList.add('bg-success')
        toastElTitle.textContent = 'Error'
    },
    default: () => {
        toastElHeader.classList.add('bg-primary')
        toastElTitle.textContent = 'Aviso'
    }
}

const getConfirmBody = (confirmType, item) => {
    return confirmation_type[confirmType]?.(item) ?? 'Función no encontrada'
}
const toastElement = document.getElementById('toast');
const toastElHeader = toastElement.querySelector('.toast-header');
const toastElTitle = toastElement.querySelector('.toast-title');
const toastElBody = toastElement.querySelector('.toast-body');
const toast = bootstrap.Toast.getInstance(toastElement);

const confirmationModalElement = document.getElementById('confirmationModal')
const confirmationTitle = confirmationModalElement.querySelector('.modal-title')
const confirmationBody = confirmationModalElement.querySelector('.modal-body')
const confirmationModal = new bootstrap.Modal(confirmationModalElement);

const confirmDialog = (title, item, type, callback) => {
    const okButton = document.getElementById('okBtn')
    const cancelButton = document.getElementById('cancelBtn')

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

    confirmationModalElement.addEventListener('hide.bs.modal', event => {
        $('#okBtn').replaceWith($('#okBtn').clone());
        $('#cancelBtn').replaceWith($('#cancelBtn').clone());
    })
}

const showToast = (msg, toastType = 'default') => {
    toastElHeader.classList.remove('bg-primary')
    toastElHeader.classList.remove('bg-success')
    toastElHeader.classList.remove('bg-danger')
    toast_type[toastType]?.()
    toastElBody.textContent = msg
    toast.show()
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
    STATUS_DISABLED,
    STATUS_ENABLED
}