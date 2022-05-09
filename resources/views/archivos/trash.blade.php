@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.trash', $item))

@section('primary-title')
    <i class="bi bi-collection-fill"></i>
    {{ $item->nombre }}
@endsection

@section('primary-content')
    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button id="confirmationDeleteButton" type="button" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <table id="dtContenido" class="table table-hover table-responsive-md table-md mt-2">
        <thead>
            <th></th>
            <th>Unidad</th>
            <th></th>
        </thead>
    </table>
@endsection

@section('scripts')

    <script>
        const dtOverrideGlobals = {
            language: dtLanguageOptions,
            paginate: true,
            ajax: {
                url: `/unidades-ajax/{{ $item->id }}/trash`,
                dataSrc: 'data',
            },
            columns: [{
                    className: 'dt-control',
                    orderable: false,
                    data: null,
                    defaultContent: ``
                },
                {
                    data: null
                },
                {
                    data: null
                },
            ],
            columnDefs: [{
                    targets: 1,
                    render: function(data, type, row, meta) {
                        renderHTML =
                            `<a href="/unidades/${data.id}" class="btn btn-link has-tooltip" 
                                data-bs-toggle="tooltip"
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
                        </button>
                        `;
                        return renderHTML;
                    }
                }
            ]
        };

        const dtContenido = $('#dtContenido').DataTable(dtOverrideGlobals);

        const confirmationModalElement = document.getElementById('confirmationModal');

        const confirmationModal = new bootstrap.Modal(confirmationModalElement, {
            keyboard: true
        });

        const confirmationDeleteButton = document.getElementById('confirmationDeleteButton');

        $('#dtContenido').on('requestChild.dt', function(e, row) {
            var data = row.data();
            row.child(format(data)).show();
        });

        $('#dtContenido').on('click', 'tbody td.dt-control', function() {
            var tr = $(this).closest('tr');
            var row = dtContenido.row(tr);

            if (row.child.isShown())
                row.child.hide();
            else {
                row.child(format(row.data())).show();
            }
        });

        $('#dtContenido tbody').on('click', '.restore-item', function() {

            const tr = $(this).closest('tr');
            const data = dtContenido.row(tr).data();

            confirmationModalElement.querySelector('.modal-title').textContent = 'Restaurar';
            confirmationModalElement.querySelector('.modal-body').innerHTML = `<div>
    <i class="bi bi-exclamation-diamond-fill" style="font-size: 2.5rem; color: orange;"></i>
    </div>
    ¿Estas seguro que desea restaurar <span class='text-danger'>${data.nombre}</span>?`;

            confirmationModal.show();

            confirmationDeleteButton.dataset.url = `/unidades-ajax/${data.id}/restore`;
            confirmationDeleteButton.dataset.type = 'PUT'
        });

        $('#dtContenido').on('click', 'tbody .delete-item', function() {
            const tr = $(this).closest('tr');
            const data = dtContenido.row(tr).data();

            confirmationModalElement.querySelector('.modal-title').textContent = 'Eliminar';
            confirmationModalElement.querySelector('.modal-body').innerHTML =
                `<div>
                    <i class="bi bi-exclamation-diamond-fill" style="font-size: 2.5rem; color: orange;"></i>
                </div>
                ¿Desea eliminar <span class='text-danger'>${data.nombre}</span>?`;

            confirmationModal.show();

            confirmationDeleteButton.dataset.url = `/unidades-ajax/${data.id}`;
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

                    dtContenido.ajax.reload();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
                }
            });

        });

        function format(data) {

            var rowItems = '';
            if (data.archivos.length == 0)
                return `<span class="text-muted">No hay archivos disponibles</span>`

            data.archivos.forEach(e => {
                rowItems += `<tr class=>
                            <td></td>    
                            <td>    
                                <a href="${e.url}" class="text-decoration-none has-tooltip" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar detalles"
                                target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-filetype-${e.extension}" style="font-size: 1.5rem;"></i>
                                ${e.nombre}
                                </a>
                            </td>
                        </tr>`

            });

            return $(rowItems).toArray();
        }

        new bootstrap.Tooltip(document.body, {
            selector: '.has-tooltip'
        });
    </script>
@endsection
