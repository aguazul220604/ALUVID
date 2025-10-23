<!DOCTYPE html>
<html lang="en">

<x-header />

<body>

    <x-preloader />

    @if (session('message') === 'ok1')
        <script>
            Swal.fire({
                text: "Serie registrada exitosamente",
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
                text: "Serie actualizada exitosamente",
                icon: "success",
                confirmButtonColor: "#00532C",
                showConfirmButton: true
            });
        </script>
    @endif
    @if (session('message') === 'update2')
        <script>
            Swal.fire({
                text: "Línea actualizada exitosamente",
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
                                                <h5 class="mb-0">Gestión de materiales: Aluminios</h5>
                                            </div>

                                            <div class="card-body table-responsive">
                                                @foreach ($productos_aluminio->groupBy('id_linea') as $lineaId => $series)
                                                    <div class="card-body table-responsive mb-4">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-2">
                                                            {{-- Mostrar nombre de línea --}}
                                                            <h5>
                                                                Series:
                                                                {{ $series->first() ? $series->first()->linea : 'Nueva línea' }}
                                                            </h5>

                                                            {{-- Botón para añadir serie --}}
                                                            <button class="btn btn-success"
                                                                style="text-transform: none;" data-bs-toggle="modal"
                                                                data-bs-target="#modalAddSerie_{{ $lineaId }}">
                                                                Añadir
                                                            </button>

                                                            {{-- Modal Añadir Serie --}}
                                                            <div class="modal fade modal-dialog-scrollable"
                                                                id="modalAddSerie_{{ $lineaId }}"
                                                                data-bs-backdrop="static" data-bs-keyboard="false"
                                                                tabindex="-1"
                                                                aria-labelledby="modalAdd_Label_{{ $lineaId }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5"
                                                                                id="modalAdd_Label_{{ $lineaId }}">
                                                                                Agregar serie a
                                                                                {{ $series->first() ? $series->first()->linea : 'Nueva línea' }}
                                                                            </h1>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <form
                                                                            action="{{ route('gestion_aluminio_admin_create_serie') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="id_linea"
                                                                                value="{{ $lineaId }}">
                                                                            <div class="modal-body">
                                                                                <div class="mb-3">
                                                                                    <label for="descripcion"
                                                                                        class="form-label">Descripción</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        id="descripcion"
                                                                                        name="descripcion" required>
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

                                                        @if ($series->count() > 0)
                                                            <table class="tabla-dinamica tablas display">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID Serie</th>
                                                                        <th>Descripción</th>
                                                                        <th>Acciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($series as $serie)
                                                                        @if ($serie->id_serie)
                                                                            <tr>
                                                                                <td>{{ $serie->id_serie }}</td>
                                                                                <td>{{ $serie->serie }}</td>
                                                                                <td>
                                                                                    <div
                                                                                        class="d-flex align-items-center gap-2">
                                                                                        {{-- Botón Editar --}}
                                                                                        <button type="button"
                                                                                            class="btn btn-secondary"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#modalEditSerie_{{ $serie->id_serie }}">
                                                                                            <i
                                                                                                class="bi bi-pencil-fill"></i>
                                                                                        </button>

                                                                                        {{-- Modal Editar --}}
                                                                                        <div class="modal fade modal-dialog-scrollable"
                                                                                            id="modalEditSerie_{{ $serie->id_serie }}"
                                                                                            tabindex="-1"
                                                                                            aria-labelledby="modalEdit_Label_{{ $serie->id_serie }}"
                                                                                            aria-hidden="true">
                                                                                            <div class="modal-dialog">
                                                                                                <div
                                                                                                    class="modal-content">
                                                                                                    <div
                                                                                                        class="modal-header">
                                                                                                        <h1 class="modal-title fs-5"
                                                                                                            id="modalEdit_Label_{{ $serie->id_serie }}">
                                                                                                            Editar serie
                                                                                                        </h1>
                                                                                                        <button
                                                                                                            type="button"
                                                                                                            class="btn-close"
                                                                                                            data-bs-dismiss="modal"
                                                                                                            aria-label="Close"></button>
                                                                                                    </div>
                                                                                                    <form
                                                                                                        action="{{ route('gestion_aluminio_admin_update_serie', $serie->id_serie) }}"
                                                                                                        method="POST">
                                                                                                        @csrf
                                                                                                        <div
                                                                                                            class="modal-body">
                                                                                                            <div
                                                                                                                class="mb-3">
                                                                                                                <label
                                                                                                                    for="descripcion_edit_{{ $serie->id_serie }}"
                                                                                                                    class="form-label">Descripción</label>
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    class="form-control"
                                                                                                                    id="descripcion_edit_{{ $serie->id_serie }}"
                                                                                                                    name="descripcion"
                                                                                                                    value="{{ $serie->serie }}"
                                                                                                                    required>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="modal-footer">
                                                                                                            <button
                                                                                                                type="button"
                                                                                                                class="btn btn-secondary"
                                                                                                                data-bs-dismiss="modal">Cancelar</button>
                                                                                                            <button
                                                                                                                type="submit"
                                                                                                                class="btn btn-primary">Actualizar</button>
                                                                                                        </div>
                                                                                                    </form>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        {{-- Botón Eliminar --}}
                                                                                        <form
                                                                                            action="{{ route('gestion_aluminio_admin_delete_serie', $serie->id_serie) }}"
                                                                                            method="POST"
                                                                                            class="formEliminar_serie_aluminio">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                            <button type="submit"
                                                                                                class="btn btn-danger">
                                                                                                <i
                                                                                                    class="bi bi-trash3-fill"></i>
                                                                                            </button>
                                                                                        </form>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>



                                            <hr>

                                            <div class="card-body table-responsive">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h5>Líneas</h5>

                                                    <!-- Botón para añadir nueva línea -->
                                                    <button class="btn btn-success" style="text-transform: none;"
                                                        data-bs-toggle="modal" data-bs-target="#modalAddLinea">
                                                        Añadir
                                                    </button>
                                                </div>

                                                <!-- Modal Añadir Línea -->
                                                <div class="modal fade modal-dialog-scrollable" id="modalAddLinea"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="modalAddLinea_Label" aria-hidden="true">

                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="modalAddLinea_Label">
                                                                    Agregar línea</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="{{ route('gestion_aluminio_admin_create_linea') }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <input type="hidden" value="2"
                                                                        name="categoria">
                                                                    <div class="mb-3">
                                                                        <label for="descripcion"
                                                                            class="form-label">Descripción</label>
                                                                        <input type="text" name="descripcion"
                                                                            id="descripcion" class="form-control"
                                                                            required>
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

                                                <!-- Tabla de líneas -->
                                                <table class="tabla-dinamica tablas display">
                                                    <thead>
                                                        <tr>
                                                            <th>ID Línea</th>
                                                            <th>Descripción</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($lineas as $linea)
                                                            <tr>
                                                                <td>{{ $linea->id }}</td>
                                                                <td>{{ $linea->descripcion }}</td>
                                                                <td>
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <!-- Botón Eliminar -->
                                                                        <form
                                                                            action="{{ route('gestion_aluminio_admin_delete_linea', $linea->id) }}"
                                                                            method="POST"
                                                                            class="formEliminar_linea_aluminio">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="btn btn-danger">
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
