@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.show', $item))

@section('primary-title')
    <i class="bi bi-collection-fill"></i>
    {{ $item->nombre }}
    <span class="float-end">
        <a href="{{ route('materias.edit', $item) }}" class="btn btn-md btn-primary" data-bs-toggle="tooltip"
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
    <div class="row justify-content-between">
        <div class="col-md-6">
            <table class="table table-borderless">
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
                        <th class="text-end">Clave de acceso</th>
                        <td>
                            <span class="alert alert-primary p-2">
                                {{ $item->clave }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-end">Creado</th>
                        <td> {{ $item->created_at }} </td>
                    </tr>
                    <tr>
                        <th class="text-end">Actualizado</th>
                        <td> {{ $item->updated_at }} </td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="col-md-4">
            <div class="d-grid gap-2 mt-2">
                <a href="{{ route('unidades.index', $item) }}" class="btn btn-md btn-primary">
                    <i class="bi bi-files"></i>
                    Contenido
                </a>
                <a href="{{ route('alumnos.index', $item) }}" class="btn btn-md btn-primary">
                    <i class="bi bi-people-fill"></i>
                    Alumnos
                    <span class="badge bg-light text-dark">
                        {{ $item->alumnos->count() }}
                    </span>
                </a>
            </div>
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
                url: `/materias-ajax/{{ $item->id }}/archive`,
                success: (data) => {
                    confirmationModal.hide();
                    showToast(data.success, 'success');
                    setTimeout(function() {
                        window.location.href = "/";
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
