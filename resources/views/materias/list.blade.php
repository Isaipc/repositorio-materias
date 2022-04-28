@section('secondary-title')
    <i class="bi bi-collection-fill"></i>
    {{ __('Materias') }}
    <span class="float-end">
        <a href="{{ route('materias.create') }}" class="btn btn-md btn-primary" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Crear nuevo">
            <i class="bi bi-plus"></i>
        </a>
        <a href="{{ route('materias.trash') }}" class="btn btn-md btn-secondary position-relative" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Mostrar eliminados">
            <i class="bi bi-trash-fill"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $archived->count() }}
                <span class="visually-hidden"></span>
            </span>
        </a>
    </span>
@endsection

@datatable(['id' => 'materiasDT'])
@slot('thead')
    <tr>
        <th>Materia</th>
        <th>Habilitado</th>
        <th></th>
    </tr>
@endslot
@enddatatable
