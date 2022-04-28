@section('secondary-title')
    <i class="bi bi-people-fill"></i>
    {{ __('Usuarios del sistema') }}
    <span class="float-end">
        <a href="{{ route('usuarios.create') }}" class="btn btn-md btn-primary" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Crear nuevo">
            <i class="bi bi-plus"></i>
        </a>
        <a href="{{ route('usuarios.trash') }}" class="btn btn-md btn-secondary position-relative" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Mostrar eliminados">
            <i class="bi bi-trash-fill"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $archived->count() }}
                <span class="visually-hidden"></span>
            </span>
        </a>
    </span>
@endsection

@datatable(['id' => 'usuariosDT'])
@slot('thead')
    <tr>
        <th>Nombre</th>
        <th class="d-none d-md-table-cell">Correo electronico</th>
        <th>Usuario</th>
        <th></th>
    </tr>
@endslot
@enddatatable
