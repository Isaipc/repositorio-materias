@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('home'))

@section('primary-title')
    @hasrole('Administrador')
        Repositorio
    @endhasrole
    @hasrole('Alumno')
        Mis materias
        <span class="float-end">
            <button id="assignMateria" class="btn btn-md btn-primary" data-bs-placement="top" data-bs-toggle="modal"
                data-bs-target="#claveModal" title="Registrarse en materia">
                <i class="bi bi-key-fill" style="font-size: 1.2rem;"></i>
            </button>
        </span>
    @endhasrole
@endsection

@section('primary-content')
    <!-- Clave Modal -->
    <div class="modal fade" id="claveModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <form id="form" action="{{ route('claves-materia.store') }}" method="POST">
            @csrf
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
        @if ($materias->count() == 0)
            <div class="alert alert-light text-center" role="alert">
                <div>
                    <i class="bi bi-info-circle-fill" style="font-size: 3rem; color: orange;"></i>
                </div>
                <span class="text-muted"> No hay materias registradas</span>
            </div>
        @else
            <div class="row row-cols-lg-4 row-cols-md-2 row-cols-sm-1 row-cols-1 g-2 g-lg-3">
                @foreach ($materias as $m)
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
                                    <a href="{{ route('unidades.index', $m) }}" class="btn btn-md btn-primary">
                                        <i class="bi bi-files"></i>
                                        Mostrar contenido
                                    </a>

                                    @hasrole('Administrador')
                                        <a href="{{ route('alumnos.index', $m) }}" class="btn btn-md btn-primary">
                                            <i class="bi bi-people-fill"></i>
                                            Alumnos
                                            <span class="badge bg-light text-dark">
                                                {{ $m->alumnos->count() }}
                                            </span>
                                        </a>
                                    @endhasrole
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-link toggle-date-format">
                                    <i class="bi bi-clock"></i>
                                </button>
                                <small class="text-muted"> Actualizado
                                    <span class="date-formatted" data-value="{{ $m->updated_at }}">{{ $m->updated_at }}
                                    </span>
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
