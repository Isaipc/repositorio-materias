@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.show', $item))

@section('primary-title')
    <i class="bi bi-person-fill"></i>
    {{ $item->nombre }}

    <span class="float-end">
        <a href="{{ route('usuarios.edit', $item) }}" class="btn btn-md btn-primary" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Editar">
            <i class="bi bi-pencil-fill"></i>
        </a>
        <button id="deleteItem" data-id="{{ $item->id }}" class="btn btn-md btn-danger" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Eliminar">
            <i class="bi bi-trash-fill"></i>
        </button>
    </span>
@endsection

@section('primary-content')
    <div class="row">
        <div class="col-md-8">
            <table class="table table-borderless table-responsive">
                <tbody>
                    <tr>
                        <th class="text-end">Nombre</th>
                        <td> {{ $item->nombre }} </td>
                    </tr>
                    <tr>
                        <th class="text-end">Estatus</th>
                        <td> {{ $item->getEstatusName() }} </td>
                    </tr>
                    <tr>
                        <th class="text-end">Creado</th>
                        <td> {{ $item->created_at }} </td>
                    </tr>
                    <tr>
                        <th class="text-end">Actualizado</th>
                        <td> {{ $item->updated_at }} </td>
                    </tr>
                    <tr>
                        <th class="text-end">Tipo de usuario</th>
                        <td>
                            @foreach ($item->roles as $r)
                                {{ $r->name }}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="text-end">Materias</th>
                        <td>
                            @if ($item->materias->count() == 0)
                                <span class="text-muted">Sin materias</span>
                            @endif
                            @foreach ($item->materias as $r)
                                <li>
                                    <a href="{{ route('materias.show', $r->id) }}" class="btn btn-link">
                                        {{ $r->nombre }}
                                    </a>
                                </li>
                            @endforeach
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const confirmationModalElement = document.getElementById('confirmationModal');
        const confirmationModal = new bootstrap.Modal(confirmationModalElement, {
            keyboard: true
        });

        $('#confirmationDeleteButton').on('click', function() {
            $.ajax({
                type: 'DELETE',
                url: `/usuarios/{{ $item->id }}/archive`,
                success: (data) => {
                    confirmationModal.hide();
                    showToast(data.success, 'success');
                    setTimeout(function() {
                        window.location.href = "/usuarios";
                    }, 2500);
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    showToast(jqXHR.responseJSON.error, 'error');
                }
            });
        });

        $('#deleteItem').on('click', function() {
            confirmationModalElement.querySelector('.modal-title').textContent = 'Eliminar';
            confirmationModalElement.querySelector('.modal-body').innerHTML =
                `<div>
            <i class="bi bi-exclamation-diamond-fill" style="font-size: 2.5rem; color: orange;"></i>
        </div>
        ¿Desea eliminar <span class='text-danger'>{{ $item->nombre }}</span>?`;
            confirmationModal.show();
        });
    </script>
@endsection
