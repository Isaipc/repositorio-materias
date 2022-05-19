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

    @datatable(['id' => 'dtUsers'])
    @slot('thead')
        <tr>
            <th></th>
            <th>Nombre</th>
            <th class="d-none d-md-table-cell">Correo electronico</th>
            <th>Usuario</th>
            <th>Materias</th>
            <th></th>
        </tr>
    @endslot
    @enddatatable
@endsection

@section('scripts')

    <script>
        const userModalElement = document.getElementById('userModal');
        const confirmationModalElement = document.getElementById('confirmationModal');

        const userModal = new bootstrap.Modal(userModalElement, {
            keyboard: true
        });

        const confirmationModal = new bootstrap.Modal(confirmationModalElement, {
            keyboard: true
        });

        let dtOverrideGlobals = {
                language: dtLanguageOptions,
                paginate: true,
                stateSave: true,
                processing: true,
                ajax: {
                    url: '/usuarios/list',
                    dataSrc: 'data',
                },
                columns: [{
                        data: null
                    },
                    {
                        data: 'nombre'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'username'
                    },
                    {
                        data: 'materias'
                    },
                    {
                        data: null
                    }
                ],
                columnDefs: [{
                        targets: 0,
                        render: function(data, type, row, meta) {
                            let renderHTML =
                                `<a href="/usuarios/${data.id}" class="btn btn-link" data-bs-toggle="tooltip"
                          data-bs-placement="top" title="Mostrar detalles">
                                <i class="bi bi-box-arrow-up-right"></i>
                        </a>`
                            return renderHTML;
                        }
                    },
                    {
                        targets: 4,
                        render: function(data, type, row, meta) {
                            let renderHTML = '';

                            if (data.length > 0) {
                                data.forEach(e => {
                                    renderHTML +=
                                        `<li>
                                    <a href="/materias/${e.id}" class="btn btn-link text-decoration-none"> 
                                            ${e.nombre}
                                            </a>
                                            </li>`
                                });
                            } else {
                                renderHTML = `<span class="text-muted">Sin materias</span>`;
                            }
                            return renderHTML;
                        }
                    },
                    {
                        targets: -1,
                        render: function(data, type, row, meta) {
                            let renderHTML = '';
                            renderHTML =
                                `<a href="/usuarios/${data.id}/editar" class="btn btn-sm btn-primary has-tooltip" 
                                data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Editar"> 
                                <i class="bi bi-pencil-fill"></i> </a>
                                <button class="btn btn-sm btn-danger delete-item has-tooltip" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                                <i class="bi bi-trash-fill"></i></button>`;
                        }
                        return renderHTML;
                    }
                },
            ],

        };

        const dtUsers = $('#dtUsers').DataTable(dtOverrideGlobals);

        $('#addUser').on('click', function() {
            userModal.show();
            $('#userForm')[0].reset();
            $('#userId').val(0);
            userModalElement.querySelector('.modal-title').textContent = 'Nuevo usuario';
        });

        $('#userForm').on('submit', function(e) {
            var form = $('#userForm');
            var data = form.serialize();
            var id = $('#userId');

            if (id.val() == 0) {
                url = '/usuarios'
                type = 'POST';
                console.log('wtfk');
            }

            $.ajax({
                type: type,
                url: url,
                dataType: 'json',
                data: data,
                success: (data) => {
                    showToast(data.success, TOAST_SUCCESS_TYPE);
                    userModal.hide();
                    form[0].reset();
                    dtUsers.ajax.reload();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.log(jqXHR.responseJSON);
                    showToast(jqXHR.responseJSON.errors.nombre, TOAST_ERROR_TYPE);
                }
            });
        });

        $('#dtUsers').on('click', 'tbody .edit-item', function() {

            var tr = $(this).closest('tr');
            var data = dtUsers.row(tr).data();

            userModal.show();

            $('#userId').val(data.id);
            $('#nombre').val(data.nombre);
            $('#username').val(data.username);
            $('#email').val(data.email);
            userModalElement.querySelector('.modal-title').textContent = 'Editar usuario';
        });

        $('#confirmationDeleteButton').on('click', function() {
            const ITEM_URL = this.dataset.url;
            const ITEM_TYPE = this.dataset.type;

            $.ajax({
                type: ITEM_TYPE,
                url: ITEM_URL,
                success: (data) => {
                    confirmationModal.hide();
                    showToast(data.success, TOAST_SUCCESS_TYPE);
                    dtUsers.ajax.reload();
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    showToast(jqXHR.responseJSON.error, TOAST_ERROR_TYPE);
                }
            });

        });

        $('#dtUsers').on('click', 'tbody .delete-item', function() {

            const ITEM_URL = this.dataset.url;

            var tr = $(this).closest('tr');
            var data = dtUsers.row(tr).data();
            var confirmationDeleteButton = document.getElementById('confirmationDeleteButton');
            console.log(data);

            confirmationModalElement.querySelector('.modal-title').textContent = 'Eliminar';
            confirmationModalElement.querySelector('.modal-body').innerHTML =
                `<div>
            <i class="bi bi-exclamation-diamond-fill" style="font-size: 2.5rem; color: orange;"></i>
        </div>
        ¿Desea eliminar <span class='text-danger'>${data.nombre}</span>?`;

            confirmationModal.show();

            confirmationDeleteButton.dataset.url = `/usuarios/${data.id}/archive`;
            confirmationDeleteButton.dataset.type = 'DELETE'
        });
    </script>
@endsection
