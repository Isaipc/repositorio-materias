@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.trash'))

@section('primary-title')
    <i class="bi bi-person-x-fill"></i>
    {{ __('Alumnos eliminados') }}
@endsection

@section('primary-content')

    @datatable(['id' => 'dtUsersTrash'])
    @slot('thead')
        <tr>
            <th>Nombre</th>
            <th class="d-none d-md-table-cell">Correo electronico</th>
            <th>Usuario</th>
            <th></th>
        </tr>
    @endslot
    @enddatatable
@endsection

@section('scripts')

    <script>
        const confirmationModalElement = document.getElementById('confirmationModal');

        const confirmationModal = new bootstrap.Modal(confirmationModalElement, {
            keyboard: true
        });
        const confirmationDeleteButton = document.getElementById('confirmationDeleteButton');

        let dtOverrideGlobals = {
            language: dtLanguageOptions,
            paginate: true,
            processing: true,
            stateSave: true,
            ajax: {
                url: '/usuarios/trash/list',
                dataSrc: 'data',
            },
            columns: [{
                    data: null
                },
                {
                    data: 'email'
                },
                {
                    data: 'username'
                },
                {
                    data: null
                },
            ],
            columnDefs: [{
                    targets: 0,
                    render: function(data, type, row, meta) {
                        renderHTML =
                            `<a href="/usuarios/${data.id}" class="btn btn-link has-tooltip" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Mostrar detalles">
                                <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                        ${data.nombre}`
                        return renderHTML;
                    }
                },
                {
                    targets: -1,
                    render: function(data, type, row, meta) {
                        renderHTML =
                            `<button type="button" class="btn btn-sm btn-success restore-item has-tooltip" data-bs-toggle="tooltip"
                             data-bs-placement="top" title="Restaurar">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-item has-tooltip" 
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar permanentemente">
                                <i class="bi bi-x"></i>
                            </button>`;
                        return renderHTML;
                    }
                },
            ],

        };
        const dtUsersTrash = $('#dtUsersTrash').DataTable(dtOverrideGlobals);
        const ITEM_URL = 'usuarios';

        $('#dtUsersTrash tbody').on('click', '.restore-item', function() {

            const tr = $(this).closest('tr');
            const data = dtUsersTrash.row(tr).data();

            confirmationModalElement.querySelector('.modal-title').textContent = 'Restaurar';
            confirmationModalElement.querySelector('.modal-body').innerHTML =
                `<div>
                <i class="bi bi-exclamation-diamond-fill" style="font-size: 2.5rem; color: orange;"></i>
                </div>
                ¿Estas seguro que desea restaurar <span class='text-danger'>${data.nombre}</span>?`;

            confirmationModal.show();

            confirmationDeleteButton.dataset.url = `/${ITEM_URL}/${data.id}/restaurar`;
            confirmationDeleteButton.dataset.type = 'PUT'
        });

        $('#dtUsersTrash').on('click', 'tbody .delete-item', function() {

            const tr = $(this).closest('tr');
            const data = dtUsersTrash.row(tr).data();

            confirmationModalElement.querySelector('.modal-title').textContent = 'Eliminar permanentemente';
            confirmationModalElement.querySelector('.modal-body').innerHTML =
                `<div>
                    <i class="bi bi-exclamation-circle-fill" style="font-size: 2.5rem; color: red;"></i>
                </div> ¿Desea eliminar permanentemente <span class='text-danger'>${data.nombre}</span>? Esta acción no se puede deshacer.`;

            confirmationModal.show();

            confirmationDeleteButton.dataset.url = `/${ITEM_URL}/${data.id}`;
            confirmationDeleteButton.dataset.type = 'DELETE'
        });

        $('#confirmationDeleteButton').on('click', function() {
            const ITEM_URL = this.dataset.url;
            const ITEM_TYPE = this.dataset.type;

            $.ajax({
                type: ITEM_TYPE,
                url: ITEM_URL,
                success: (data) => {
                    confirmationModal.hide();
                    showToast(data.success, TOAST_SUCCESS_TYPE);
                    dtUsersTrash.ajax.reload();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
                }
            });

        });
    </script>
@endsection
