<div class="card mt-2 shadow-sm">
    <div class="card-body container">
        @if ($rows->count() > 0)
        <table id="datatable" class="table table-hover table-responsive-md table-md mt-2">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>URL</th>
                    <th>Estatus</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $key=> $r_item)
                <tr class="">
                    <td>{{ $key + 1 }}</td>
                    <td scope="row"> {{ $r_item->nombre }} </td>
                    <td> <a href="{{ $r_item->url }}">{{ $r_item->url }}</a> </td>
                    <td>{{ $r_item->getEstatusName() }} </td>
                    <td>
                        @if ($r_item->estatus == 0)
                        <a href="javascript: document.getElementById('restore-{{ $r_item->id }}').submit()"
                            class="btn btn-sm btn-success">
                            <i class="bi bi-upload"></i>
                        </a>
                        <form id="restore-{{ $r_item->id }}" action="{{ route('archivos.restore', $r_item->id) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                        </form>
                        <a href="javascript: document.getElementById('delete-{{ $r_item->id }}').submit()"
                            class="btn btn-sm btn-danger">
                            <i class="bi bi-x"></i>
                        </a>
                        <form id="delete-{{ $r_item->id }}" action="{{ route('archivos.destroy', $r_item->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                        </form>

                        @else
                        <a href="{{ route('archivos.show', [$materia , $r_item->id]) }} " class="btn btn-sm btn-link">
                            Mostrar detalles </a>
                        <a href="{{ route('archivos.edit',[$materia, $r_item]) }} " class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-fill"></i> </a>
                        <a href="javascript: document.getElementById('archive-{{ $r_item->id }}').submit()"
                            class="btn btn-sm btn-danger">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                        <form id="archive-{{ $r_item->id }}" action="{{ route('archivos.destroy', $r_item->id) }}"
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
        <div class="alert alert-info" role="alert">No se encontraron archivos.</div>
        @endif
    </div>
</div>