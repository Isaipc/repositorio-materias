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
        </tr>
    @endslot
    @enddatatable
@endsection

@section('secondary-content')
    @include('materias.list')
@endsection

@section('scripts')
    <script>
        let dtOverrideGlobals = {
            language: dtLanguageOptions,
            paginate: true,
            ajax: {
                url: `/alumnos/{{ $item->id }}/list`,
                dataSrc: 'data'
            },
            columns: [{
                    data: null
                },
                {
                    data: 'email'
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
            }]
        };

        var dtAlumnos = $('#dtAlumnos').DataTable(dtOverrideGlobals);

        new bootstrap.Tooltip(document.body, {
            selector: '.has-tooltip'
        });
    </script>
@endsection
