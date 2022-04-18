<div class="card mt-2">
    <div class="card-body container shadow-sm">

        @if ($rows->count() > 0)
        <table id="datatable" class="table table-hover table-responsive-sm mt-2">
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
                        <a href="{{ route('materias.show', $r_item->id) }} " class="btn btn-link"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Mostrar detalles">
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                        {{ $r_item->nombre }}
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input change-status-materia" type="checkbox" role="switch" @if (
                                $r_item->estatus == 1 ) checked @endif
                            @if ( $r_item->isArchived()) disabled @endif
                            data-id="{{ $r_item->id }}">
                        </div>
                    </td>
                    <td>
                        @if ($r_item->isArchived())
                        <a href="javascript: document.getElementById('restore-{{ $r_item->id }}').submit()"
                            class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Restaurar">
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
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-materia" data-id="{{ $r_item->id }}"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-item="{{ $r_item }}"
                            title="Eliminar">
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
        @else
        <div class="alert alert-info" role="alert">No se encontraron registros.</div>
        @endif
    </div>
</div>