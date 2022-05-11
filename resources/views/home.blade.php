@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('home'))

@section('primary-title')
    @hasrole('Administrador')
        Repositorio
    @endhasrole
    @hasrole('Alumno')
        Mis materias
        <span class="float-end">
            <button id="assignMateria" class="btn btn-md btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Registrarse en materia">
                <i class="bi bi-key-fill" style="font-size: 1.2rem;"></i>
            </button>
        </span>
    @endhasrole
@endsection

@section('primary-content')
    <!-- Clave Modal -->
    <div class="modal fade" id="claveModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <form id="form" action="javascript:void(0)" method="POST">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Registrarse en materia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="clave" class="form-label text-md-right">Clave de acceso</label>
                        <input id="clave" type="text" class="form-control" name="clave" maxlength="100" required
                            value="{{ old('clave') }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-md btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="row row-cols-lg-4 row-cols-md-2 row-cols-sm-1 row-cols-1 g-2 g-lg-3">
            @hasrole('Administrador')
                @foreach ($materias_rep as $m)
                    <div class="col p-2">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h5 class="card-title">
                                    <a href="{{ route('materias.show', $m) }}"
                                        class="btn btn-sm btn-link has-tooltip float-start" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Mostrar detalles">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                    {{ $m->nombre }}
                                </h5>
                            </div>
                            <div class="card-body">
                                {{-- <div class="d-lg-flex justify-content-around gap-2 mt-2"> --}}
                                <div class="d-grid gap-2 mt-2">
                                    <a href="{{ route('archivos.index', $m) }}" class="btn btn-md btn-primary">
                                        <i class="bi bi-files"></i>
                                        Mostrar contenido
                                    </a>
                                    <a href="{{ route('alumnos.index', $m) }}" class="btn btn-md btn-primary">
                                        <i class="bi bi-people-fill"></i>
                                        Alumnos
                                        <span class="badge bg-light text-dark">
                                            {{ $m->alumnos->count() }}
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted"> Actualizado
                                    {{ Carbon\Carbon::parse($m->updated_at)->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endhasrole
        </div>
    </div>
    @hasrole('Alumno')
        <div id="misMaterias" class="d-flex flex-wrap justify-content-center"></div>
        <div id="misMateriasAlert" class="alert alert-light text-center" role="alert" style="display: none;">
            <div>
                <i class="bi bi-info-circle-fill" style="font-size: 3rem; color: orange;"></i>
            </div>
            <span class="text-muted"> Todavía no estas registrado en alguna materia. </span>
        </div>
    @endhasrole
@endsection

@section('scripts')
    <script>
        const claveModalElement = document.getElementById('claveModal');
        const claveModal = new bootstrap.Modal(claveModalElement, {
            keyboard: true
        });
        const containerAlert = $('#misMateriasAlert');

        $(() => {
            getMaterias();
        })

        $('#assignMateria').on('click', function() {
            claveModal.show();
        });

        $('#form').on('submit', function(e) {
            var form = $('#form');
            var data = form.serialize();
            console.log(data);

            $.ajax({
                type: 'POST',
                url: '/alumnos/materias',
                dataType: 'json',
                data: data,
                success: (data) => {
                    showToast(data.success, TOAST_SUCCESS_TYPE);
                    claveModal.hide();
                    form[0].reset();
                    getMaterias();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    showToast(jqXHR.responseJSON.message, TOAST_ERROR_TYPE);
                }
            });
        });

        function getMaterias() {
            $.ajax({
                type: 'GET',
                url: '/alumnos/materias',
                dataType: 'json',
                success: (data) => {
                    let container = $('#misMaterias');
                    let htmlResult = '';

                    if (data.materias.length == 0) {
                        containerAlert.show();
                    } else {
                        containerAlert.hide();
                        data.materias.forEach(e => {
                            htmlResult += renderMateriaItem(e);
                        });
                        container.html(htmlResult);
                    }
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    showToast(jqXHR.responseJSON.message, TOAST_ERROR_TYPE);
                }
            });
        }

        function renderMateriaItem(data) {
            let html = `<div class="card bg-light col-md-4 ms-2 mt-2">
                <div class="card-body text-center">
                    <h5 class="card-title"> ${data.nombre} </h5>`;


            html += data.estatus == 1 ?
                `<a href="/materias/${data.id}/contenido" class="btn btn-md btn-primary">
                            <i class="bi bi-files"></i>Mostrar contenido
                            </a>` : `<p class="text-muted mt-3"> Esta materia no se encuentra disponible. </p>`;

            html += `</div>
            </div>`;
            return html;
        }
    </script>
@endsection
