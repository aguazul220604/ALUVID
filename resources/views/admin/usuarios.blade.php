<!DOCTYPE html>
<html lang="en">

<x-header />

<body>

    <x-preloader />

    @if (session('message') === 'update')
        <script>
            Swal.fire({
                text: "Usuario actualizado exitosamente",
                icon: "success",
                confirmButtonColor: "#00532C",
                showConfirmButton: true
            });
        </script>
    @endif

    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <x-topbar-admin :user="$user" />

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">

                    <x-navbar-admin />

                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Panel de gestión administrativa</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <div class="page-body">
                                        <div class="card">

                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">Gestión de usuarios</h5>
                                            </div>

                                            <div class="card-body table-responsive">
                                                <table class="table table-bordered table-hover w-100 dark">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Función</th>
                                                            <th>Usuario</th>
                                                            <th>Configuración</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($users as $user)
                                                            <tr>
                                                                <td>{{ $user->id }}</td>
                                                                <td>{{ $user->name }}</td>
                                                                <td>{{ $user->email }}</td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#modalEdit_{{ $user->id }}">
                                                                            <i class="bi bi-pencil-fill"></i>
                                                                        </button>
                                                                        <div class="modal fade modal-dialog-scrollable"
                                                                            id="modalEdit_{{ $user->id }}"
                                                                            data-bs-backdrop="static"
                                                                            data-bs-keyboard="false" tabindex="-1"
                                                                            aria-labelledby="modalEdit_Label"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5"
                                                                                            id="modalEdit_Label">
                                                                                            Información del usuario
                                                                                        </h1>
                                                                                        <button type="button"
                                                                                            class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
                                                                                    </div>
                                                                                    <form
                                                                                        action="{{ route('usuarios_update') }}"
                                                                                        method="POST"
                                                                                        enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div class="modal-body">
                                                                                            <input type="hidden"
                                                                                                value="{{ $user->id }}"
                                                                                                name="id">

                                                                                            <div class="mb-3">
                                                                                                <label for="name"
                                                                                                    class="form-label"><b>Función</b></label>
                                                                                                <input type="text"
                                                                                                    id="name"
                                                                                                    name="name"
                                                                                                    class="form-control"
                                                                                                    value="{{ $user->name }}"
                                                                                                    readonly>
                                                                                            </div>
                                                                                            <div class="mb-3">
                                                                                                <label for="email"
                                                                                                    class="form-label"><b>Usuario</b></label>
                                                                                                <input type="text"
                                                                                                    id="email"
                                                                                                    name="email"
                                                                                                    class="form-control"
                                                                                                    value="{{ $user->email }}">
                                                                                            </div>

                                                                                            <div class="mb-3">
                                                                                                <label for="password"
                                                                                                    class="form-label"><b>Nueva
                                                                                                        contraseña</b></label>
                                                                                                <div
                                                                                                    class="input-group">
                                                                                                    <input
                                                                                                        type="password"
                                                                                                        id="password"
                                                                                                        name="password"
                                                                                                        class="form-control"
                                                                                                        placeholder="Ingresa nueva contraseña">
                                                                                                    <button
                                                                                                        class="btn btn-outline-secondary"
                                                                                                        type="button"
                                                                                                        id="toggle-password">
                                                                                                        <i class="bi bi-eye-slash"
                                                                                                            id="eye-icon"></i>
                                                                                                    </button>
                                                                                                </div>

                                                                                                <small
                                                                                                    class="form-text text-muted">Deje
                                                                                                    en blanco si no
                                                                                                    desea
                                                                                                    cambiar la
                                                                                                    contraseña</small>
                                                                                            </div>

                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-bs-dismiss="modal">Cancelar</button>
                                                                                            <button type="submit"
                                                                                                class="btn btn-primary">Actualizar</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />

</body>

</html>
<script src="{{ asset('js/admin.js') }}"></script>
