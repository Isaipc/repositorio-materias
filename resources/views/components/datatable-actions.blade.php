@php
$route = $model . 's';
@endphp

<a href="{{ route("$route.edit", $r_item->id) }} " class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
    data-bs-placement="top" title="Editar">
    <i class="bi bi-pencil-square"></i>
</a>
<a href="javascript:void(0)" class="btn btn-sm btn-danger delete-{{ $model }}" data-bs-toggle="tooltip"
    data-bs-placement="top" data-id="{{ $r_item->id }}" data-name="{{ $r_item->nombre }}"
    data-url="/{{ $route }}" title="Eliminar">
    <i class="bi bi-trash-fill"></i>
</a>
