<div class="card mt-2">
    <div class="card-body container shadow-sm">

        @if ($rows->count() > 0)
        <table id="datatable" class="table table-hover table-responsive-sm mt-2">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Estatus</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $key=> $r_item)
                <tr class="data-row">
                    <td scope="row">{{ ++$key}} </td>
                    <td>{{ $r_item->nombre }} </td>
                    <td>{{ $r_item->getEstatusName() }} </td>
                    <td>
                        @if ($r_item->estatus == 0)
                        <a href="javascript: document.getElementById('restore-{{ $r_item->id }}').submit()"
                            class="btn btn-sm btn-success">
                            <i class="bi bi-upload"></i>
                        </a>
                        <form id="restore-{{ $r_item->id }}" action="{{ route('materias.restore', $r_item->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                        </form>
                        @else
                        <a href="{{ route('materias.show', $r_item->id) }} " class="btn btn-sm btn-link">
                            Mostrar detalles
                        </a>
                        <a href="{{ route('materias.edit', $r_item->id) }} " class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="javascript: document.getElementById('delete-{{ $r_item->id }}').submit()"
                            class="btn btn-sm btn-danger">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                        <a href="{{ route('archivos.index', $r_item->id) }} " class="btn btn-sm btn-light">
                            <i class="bi bi-file-earmark-fill"></i>
                        </a>

                        <form id="delete-{{ $r_item->id }}" action="{{ route('materias.destroy', $r_item->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                        </form>



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