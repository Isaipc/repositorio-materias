@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('alumnos.index', $item))

@section('primary-title')
    <i class="bi bi-people-fill"></i>
    {{ __('Alumnos en materias') }}
@endsection


@section('primary-content')
    @datatable(['id' => 'dtAlumnos'])
    @slot('thead')
        <tr>
            <th>Alumno</th>
            <th>Correo</th>
            <th>Registrado</th>
        </tr>
    @endslot
    @enddatatable
@endsection

@section('scripts')
    <script>
        let dtOverrideGlobals = {
            language: dtLanguageOptions,
            paginate: true,
            responsive: true,
            ajax: {
                url: `/alumnos/{{ $item->id }}/list`,
                dataSrc: 'data'
            },
            columns: [{
                    data: null
                },
                {
                    data: 'email'
                },
                {
                    data: 'pivot.created_at'
                }
            ],
            columnDefs: [{
                    targets: 0,
                    render: function(data, type, row, meta) {
                        renderHTML =
                            `<a href="/usuarios/${data.id}" class="btn btn-link has-tooltip" 
                                data-bs-toggle="tooltip"
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
                        return `${moment(data).fromNow()}`;
                    }
                }
            ]
        };

        var dtAlumnos = $('#dtAlumnos').DataTable(dtOverrideGlobals);

        new bootstrap.Tooltip(document.body, {
            selector: '.has-tooltip'
        });
    </script>
@endsection
