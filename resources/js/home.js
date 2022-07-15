import { showToast } from './ui';

const claveModalElement = document.getElementById('claveModal')
const claveModal = new bootstrap.Modal(claveModalElement)

$('#assignMateria').on('click', () => claveModal.show())

$('#form').on('submit', function (e) {
    e.preventDefault()
    const form = $('#form');
    const data = form.serialize();

    $.ajax({
        type: 'POST',
        url: '/claves-materia',
        dataType: 'json',
        data: data,
        success: (data) => {
            showToast(data.success, 'success')
            claveModal.hide()
            form[0].reset()
            setTimeout(() => window.location.href = "/", 3000)
        },
        error: (jqXHR, textStatus, errorThrown) => {
            showToast(jqXHR.responseJSON.message, 'error')
        }
    })
})
