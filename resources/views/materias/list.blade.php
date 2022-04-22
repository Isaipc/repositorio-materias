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

<table class="table table-hover table-responsive-sm datatable mt-2">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Habilitado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $key=> $r_item)
        <tr class="data-row" id="rowItem{{ $r_item->id }}">
            <td>{{ ++$key}} </td>
            <td>
                <a href="{{ route('materias.show', $r_item->id) }} " class="btn btn-link" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Mostrar detalles">
                    <i class="bi bi-box-arrow-up-right"></i>
                </a>
                {{ $r_item->nombre }}
            </td>
            <td>
                <div class="form-check form-switch">
                    <input class="form-check-input change-status" type="checkbox" role="switch" @if ( $r_item->estatus
                    == 1 ) checked @endif
                    @if ( $r_item->isArchived()) disabled @endif
                    data-id="{{ $r_item->id }}" data-url="/materias">
                </div>
            </td>
            <td>
                @if ($r_item->isArchived())
                <a href="javascript: document.getElementById('restore-{{ $r_item->id }}').submit()"
                    class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Restaurar">
                    <i class="bi bi-upload"></i>
                </a>
                <form id="restore-{{ $r_item->id }}" action="{{ route('materias.restore', $r_item->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                </form>
                @else
                <a href="{{ route('materias.edit', $r_item->id) }} " class="btn btn-sm btn-primary"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-materia" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-id="{{ $r_item->id }}" data-name="{{ $r_item->nombre }}"
                    data-url="/materias" title="Eliminar">
                    <i class="bi bi-trash-fill"></i>
                </a>

                <a href="{{ route('archivos.index', $r_item->id) }} " class="btn btn-sm btn-light"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar archivos">
                    <i class="bi bi-file-earmark-fill"></i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>