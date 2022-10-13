import * as ui from './ui';

$('#materiaForm').on('submit', function (e) {
    const form = $('#materiaForm')
    const data = form.serialize()
    const id = $('#itemId').val()

    $.ajax({
        url: `/materias-ajax/${id}`,
        type: 'PUT',
        dataType: 'json',
        data: data,
        success: (data) => {
            ui.showToast(data.success, 'success')
       },
        error: (jqXHR, textStatus, errorThrown) => {
            ui.showToast(jqXHR.responseJSON.message, 'error')
        }
    });
});

$('#buttonRandomKey').on('click', function () {
    $('#clave').val(ui.generateRandomKey())
})
