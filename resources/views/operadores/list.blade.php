@if ($rows->count() > 0)
<table class="table table-striped table-responsive-sm table-sm mt-2">
    <thead>
        <tr>
            <th>#</th>
            <th>Apellidos</th>
            <th>Nombre</th>
            <th>No. licencia</th>
            <th>Clase licencia</th>
            <th>Venc. licencia</th>
            <th>Usuario</th>
            <th colspan="3">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $key=> $r_item)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td scope="row">{{ $r_item->apellidos }} </td>
            <td> {{ $r_item->nombre }} </td>
            <td>{{ $r_item->no_licencia }} </td>
            <td>{{ $r_item->clas_licencia }} </td>
            <td>{{ Carbon\Carbon::parse($r_item->venc_licencia)->format('d/m/Y') }} </td>
            <td>{{ is_null($r_item->user) ? '-' : $r_item->user->username }} </td>

            @if ($r_item->estatus == 1)
            <td>
                <a href="{{ route('operadores.edit', $r_item->id) }} " class="btn btn-sm btn-secondary">
                    <i class="bi bi-pencil-fill"></i>
                </a>
            </td>
            <td>
                <a href="javascript: document.getElementById('delete-{{ $r_item->id }}').submit()"
                    class="btn btn-sm btn-danger">
                    <i class="bi bi-x"></i>
                </a>
                <form id="delete-{{ $r_item->id }}" action="{{ route('operadores.destroy', $r_item->id) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
            @else
            <td>
                <a href="javascript: document.getElementById('restore-{{ $r_item->id }}').submit()"
                    class="btn btn-sm btn-success">
                    <i class="bi bi-upload"></i>
                </a>
                <form id="restore-{{ $r_item->id }}" action="{{ route('operadores.restore', $r_item->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info" role="alert">No se encontraron registros.</div>
@endif