<!DOCTYPE html>
<html lang="en">

<x-header />

<body>

    <x-preloader />

    @if (session('message') === 'ok1')
        <script>
            Swal.fire({
                text: "Tonalidad registrada exitosamente",
                icon: "success",
                confirmButtonColor: "#00532C",
                showConfirmButton: true
            });
        </script>
    @endif
    @if (session('message') === 'ok2')
        <script>
            Swal.fire({
                text: "Espesor registrado exitosamente",
                icon: "success",
                confirmButtonColor: "#00532C",
                showConfirmButton: true
            });
        </script>
    @endif
    @if (session('message') === 'existe')
        <script>
            Swal.fire({
                text: "Producto ya existente",
                icon: "warning",
                confirmButtonColor: "#00532C",
                showConfirmButton: true
            });
        </script>
    @endif
    @if (session('message') === 'update1')
        <script>
            Swal.fire({
                text: "Tonalidad actualizado exitosamente",
                icon: "success",
                confirmButtonColor: "#00532C",
                showConfirmButton: true
            });
        </script>
    @endif
    @if (session('message') === 'update_stock')
        <script>
            Swal.fire({
                text: "Stock actualizado exitosamente",
                icon: "success",
                confirmButtonColor: "#00532C",
                showConfirmButton: true
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            Swal.fire({
                text: "{{ $errors->first() }}",
                icon: "warning",
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
                                                <h5 class="mb-0">Gestión de materiales: Vidrios</h5>
                                            </div>

                                            <div class="card-body table-responsive">

                                                {{-- Tabla de Tonalidades --}}
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h5>Tonalidades</h5>
                                                    {{-- Botón para añadir --}}
                                                    <button class="btn btn-success" style="text-transform: none;"
                                                        data-bs-toggle="modal" data-bs-target="#modalAddTonalidad">
                                                        Añadir
                                                    </button>

                                                    {{-- Modal Añadir --}}
                                                    <div class="modal fade modal-dialog-scrollable"
                                                        id="modalAddTonalidad" data-bs-backdrop="static"
                                                        data-bs-keyboard="false" tabindex="-1"
                                                        aria-labelledby="modalAdd_Label" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="modalAdd_Label">
                                                                        Agregar tonalidad
                                                                    </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('gestion_vidrio_admin_create_tonalidad') }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="descripcion"
                                                                                class="form-label">Descripción</label>
                                                                            <input type="text" class="form-control"
                                                                                id="descripcion" name="descripcion"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="img"
                                                                                class="form-label">Imagen</label>
                                                                            <input type="file" class="form-control"
                                                                                id="img" name="img"
                                                                                accept="image/*" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Cancelar</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Almacenar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <table class="tabla-dinamica tablas display">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Descripción</th>
                                                            <th>Imagen</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($vidrio_tonalidades as $tonalidad)
                                                            <tr>
                                                                <td>{{ $tonalidad->id }}</td>
                                                                <td>{{ $tonalidad->descripcion }}</td>
                                                                <td>
                                                                    <img src="{{ asset($tonalidad->imagen) }}"
                                                                        alt="{{ $tonalidad->descripcion }}"
                                                                        width="60">
                                                                </td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#modalEdit_{{ $tonalidad->id }}">
                                                                            <i class="bi bi-pencil-fill"></i>
                                                                        </button>
                                                                        <div class="modal fade modal-dialog-scrollable"
                                                                            id="modalEdit_{{ $tonalidad->id }}"
                                                                            data-bs-backdrop="static"
                                                                            data-bs-keyboard="false" tabindex="-1"
                                                                            aria-labelledby="modalEdit_Label"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5"
                                                                                            id="modalEdit_Label">
                                                                                            Información del producto
                                                                                        </h1>

                                                                                        <button type="button"
                                                                                            class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
                                                                                    </div>
                                                                                    <form
                                                                                        action="{{ route('gestion_vidrio_admin_update_tonalidad', $tonalidad->id) }}"
                                                                                        method="POST"
                                                                                        enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div class="modal-body">
                                                                                            <input type="hidden"
                                                                                                value="{{ $tonalidad->id }}">
                                                                                            <div class="mb-3">
                                                                                                <label
                                                                                                    for="descripcion"
                                                                                                    class="form-label">Descripción</label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    name="descripcion"
                                                                                                    value="{{ $tonalidad->descripcion }}"
                                                                                                    required>
                                                                                            </div>

                                                                                            <div class="mb-3">
                                                                                                <label for="imagen"
                                                                                                    class="form-label"><b>Imagen</b></label>
                                                                                                <input type="file"
                                                                                                    id="imagen"
                                                                                                    name="imagen"
                                                                                                    class="form-control">
                                                                                                @if ($tonalidad->imagen)
                                                                                                    <div
                                                                                                        class="mt-2">
                                                                                                        <img src="{{ asset($tonalidad->imagen) }}"
                                                                                                            alt="{{ $tonalidad->descripcion }}"
                                                                                                            style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc;">
                                                                                                    </div>
                                                                                                @endif
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

                                                                        <form
                                                                            action="{{ route('gestion_vidrio_admin_delete_tonalidad', $tonalidad->id) }}"
                                                                            method="POST"
                                                                            class="formEliminar_tonalidades">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger ms-2">
                                                                                <i class="bi bi-trash3-fill"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                <hr>

                                                {{-- Tabla de Milímetros --}}
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h5>Espesor (mm)</h5>
                                                    <button class="btn btn-success" style="text-transform: none;"
                                                        data-bs-toggle="modal" data-bs-target="#modalAddEspesor">
                                                        Añadir
                                                    </button>

                                                    {{-- Modal Añadir --}}
                                                    <div class="modal fade modal-dialog-scrollable"
                                                        id="modalAddEspesor" data-bs-backdrop="static"
                                                        data-bs-keyboard="false" tabindex="-1"
                                                        aria-labelledby="modalAdd_Label" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="modalAdd_Label">
                                                                        Agregar espesor
                                                                    </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('gestion_vidrio_admin_create_mm') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="mm"
                                                                                class="form-label">Medida</label>
                                                                            <input type="number" class="form-control"
                                                                                id="mm" name="mm"
                                                                                min="1" step="1"
                                                                                required>

                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Cancelar</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Almacenar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <table class="tabla-dinamica tablas display">
                                                    <thead>
                                                        <tr>
                                                            <th>Milímetros</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($vidrio_mm as $mm)
                                                            <tr>
                                                                <td>{{ $mm->mm }} mm</td>
                                                                <td>
                                                                    <form
                                                                        action="{{ route('gestion_vidrio_admin_delete_mm', $mm->id) }}"
                                                                        method="POST" class="formEliminar_espesor">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger ms-2">
                                                                            <i class="bi bi-trash3-fill"></i>
                                                                        </button>
                                                                    </form>
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

<script src="{{ asset('js/tables_gestion_materiales.js') }}"></script>
