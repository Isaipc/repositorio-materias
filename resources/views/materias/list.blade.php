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

@datatable
@slot('thead')
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Habilitado</th>
        <th></th>
    </tr>
@endslot
@slot('tbody')
    @foreach ($rows as $key => $r_item)
        <tr class="data-row" id="rowItem{{ $r_item->id }}">
            <td>{{ ++$key }} </td>
            <td>
                @dtlink(['link' => 'materias.show', 'id' => $r_item->id])
                @enddtlink
                {{ $r_item->nombre }}
            </td>
            <td>
                @statusswitch(['route' => 'materias', 'r_item' => $r_item])
                @endstatusswitch
            </td>
            <td>
                @dtactions(['model' => 'materia', 'r_item' => $r_item])
                @enddtactions
                <a href="{{ route('archivos.index', $r_item->id) }} " class="btn btn-sm btn-light" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Mostrar contenido">
                    <i class="bi bi-file-earmark-fill"></i>
                </a>

            </td>
        </tr>
    @endforeach
@endslot
@enddatatable
