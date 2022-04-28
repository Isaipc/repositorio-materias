@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.index', $item))

@section('primary-title')
    {{ $item->nombre }}
@endsection

@section('primary-content')
    <table id="dtContenido" data-materia="{{ $item->id }}" class="table table-hover table-responsive-md table-md mt-2">
        <thead>
            <th></th>
            <th>Unidad</th>
            <th>Habilitado</th>
            <th></th>
        </thead>
    </table>
@endsection

@section('secondary-content')
    @include('materias.list')
@endsection

@section('scripts')
    <script>
        let dtOverrideGlobals = {
            language: {
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

            },
            paginate: true,
            stateSave: true,
            ajax: {
                url: `/unidades/{{ $item->id }}/list`,
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
                    data: 'estatus'
                },
                {
                    data: null
                },
            ],
            columnDefs: [{
                    targets: 1,
                    render: function(data, type, row, meta) {
                        renderHTML =
                            `<a href="/materias/${data.id}" class="btn btn-link" data-bs-toggle="tooltip"
                      data-bs-placement="top" title="Mostrar detalles">
                            <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                    ${data.nombre}`
                        return renderHTML;
                    }
                },
                {
                    targets: 2,
                    render: function(data, type, row, meta) {
                        return `<div class="form-check form-switch">
            <input class="form-check-input change-status" ${data.estatus == 1 ? 'checked' : ''} type="checkbox" role="switch"
            data-url="materias">
            </div>`;
                    }
                },
                {
                    targets: -1,
                    render: function(data, type, row, meta) {
                        renderHTML =
                            `<a href="/materias/${data.id}/editar" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Editar">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <button class="btn btn-sm btn-danger delete-item" data-bs-toggle="tooltip" data-url="materias"
                        data-bs-placement="top" title="Eliminar">
                        <i class="bi bi-trash-fill"></i>
                    </button>`;
                        return renderHTML;
                    }
                },
            ],
        };


        let dtOverrideContenido = dtOverrideGlobals;
        var dtContenido = $('#dtContenido').DataTable(dtOverrideGlobals);

        let dtChildOptions = {
            language: {
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

            },
            paginate: false,
            stateSave: true,
        };


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

        function format2(data) {

            return `<table id="dtArchivos_${data.id}" class="table table-hover table-responsive-md table-md mt-2 datatable">
        <thead>
            <th></th>
            <th>Archivo</th>
            <th></th>
        </thead>
        </table>`;
        }

        function format(data) {

            var rowItems = '';
            if (data.archivos.length == 0)
                return `<span>No hay archivos disponibles</span>`

            data.archivos.forEach(e => {
                rowItems += `<tr class=>
                            <td></td>    
                            <td>    
                                <a href="${e.url}" class="text-decoration-none">
                                <i class="bi bi-file-earmark-fill"></i>
                                ${e.nombre}
                                </a>
                            </td>
                            <td>
                        <div class="form-check form-switch">
            <input class="form-check-input change-status" ${data.estatus == 1 ? 'checked' : ''} type="checkbox" role="switch"
            data-url="materias">
            </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger delete-item" data-bs-toggle="tooltip" data-url="materias"
                                    data-bs-placement="top" title="Eliminar">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>`

            });

            return $(rowItems).toArray();
        }
    </script>
@endsection
