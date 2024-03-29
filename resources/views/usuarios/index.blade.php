@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.index'))

@section('primary-title')
    <i class="bi bi-people-fill"></i>
    {{ __('Alumnos') }}
    <span class="float-end">
        <button id="addUser" class="btn btn-md btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
            title="Crear nuevo">
            <i class="bi bi-plus"></i>
        </button>
        <a href="{{ route('usuarios.trash') }}" class="btn btn-md btn-secondary position-relative" data-bs-toggle="tooltip"
            data-bs-placement="top" title="Mostrar eliminados">
            <i class="bi bi-trash-fill"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $archived->count() }}
                <span class="visually-hidden"></span>
            </span>
        </a>
    </span>
@endsection

@section('primary-content')
    <!-- Save Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <form id="userForm" action="javascript:void(0)" method="POST">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input id="userId" type="hidden" name="id" value="0">
                        <div class="mb-3">
                            <label for="name" class="text-md-right">
                                <i class="bi bi-asterisk text-danger required"></i>
                                {{ __('Nombre') }}
                            </label>

                            <input id="nombre" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                maxlength="100">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-right">
                                <i class="bi bi-asterisk text-danger required"></i>
                                {{ __('Usuario') }}
                            </label>

                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                                name="username" value="{{ old('username') }}" required autocomplete="username" autofocus
                                maxlength="10">

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">
                                <i class="bi bi-asterisk text-danger required"></i>
                                {{ __('Correo electrónico') }}
                            </label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" autocomplete="email" maxlength="50">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right">
                                <i class="bi bi-asterisk text-danger required"></i>
                                {{ __('Contraseña') }}
                            </label>

                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                                <i class="bi bi-asterisk text-danger required"></i>
                                {{ __('Confirmar contraseña') }}
                            </label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-md btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @datatable(['id' => 'table'])
    @slot('thead')
        <tr>
            <th></th>
            <th>Nombre</th>
            <th>Correo electronico</th>
            <th>Usuario</th>
            <th>Materias</th>
            <th></th>
        </tr>
    @endslot
    @enddatatable
@endsection

@section('scripts')
    <script src="{{ asset('js/alumnos.js') }}"></script>
@endsection
