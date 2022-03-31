@if ($rows->count() > 0)
<table id="datatable" class="table table-striped table-responsive-sm table-sm mt-2">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $key=> $r_item)
        <tr>
            <td scope="row">{{ ++$key}} </td>
            <td>{{ $r_item->name }} </td>
            <td>
                @if ($r_item->estatus == 1)
                <a href="{{ route('roles.show', $r_item->id) }} " class="btn btn-sm btn-link">
                    <i class="bi bi-eye-fill"></i>
                </a>
                <a href="{{ route('roles.edit', $r_item->id) }} " class="btn btn-sm btn-secondary">
                    <i class="bi bi-pencil-fill"></i>
                </a>
                <a href="javascript: document.getElementById('delete-{{ $r_item->id }}').submit()"
                    class="btn btn-sm btn-danger">
                    <i class="bi bi-x"></i>
                </a>
                <form id="delete-{{ $r_item->id }}" action="{{ route('roles.destroy', $r_item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
                @else
                <a href="javascript: document.getElementById('restore-{{ $r_item->id }}').submit()"
                    class="btn btn-sm btn-success">
                    <i class="bi bi-upload"></i>
                </a>
                <form id="restore-{{ $r_item->id }}" action="{{ route('roles.restore', $r_item->id) }}" method="POST">
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