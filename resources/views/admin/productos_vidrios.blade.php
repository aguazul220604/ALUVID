<!DOCTYPE html>
<html lang="en">

<x-header />

<body>

    <x-preloader />

    @if (session('message') === 'ok')
        <script>
            Swal.fire({
                text: "Producto registrado exitosamente",
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
    @if (session('message') === 'update')
        <script>
            Swal.fire({
                text: "Producto actualizado exitosamente",
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
                                                <h5 class="mb-0">Gestión de productos: Vidrios</h5>

                                                <div class="d-flex gap-2 ms-auto">
                                                    <a href="{{ route('descargar.inventario.vidrio.admin') }}"
                                                        target="_blank" class="btn btn-dark"
                                                        style="text-transform: none;">
                                                        Descargar inventario
                                                    </a>

                                                    <button class="btn btn-success" style="text-transform: none;"
                                                        data-bs-toggle="modal" data-bs-target="#modalAddProduct">
                                                        Agregar producto
                                                    </button>

                                                    <a href="{{ route('gestion_vidrio_admin_show') }}" target="_blank"
                                                        class="btn btn-primary" style="text-transform: none;">
                                                        Gestión
                                                    </a>

                                                </div>


                                                <div class="modal fade modal-dialog-scrollable" id="modalAddProduct"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="modalAdd_Label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="modalAdd_Label">
                                                                    Agregar
                                                                    producto</h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('vidrio_add_product') }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="tonalidad"
                                                                            class="form-label"><b>Tonalidad</b></label>
                                                                        <select name="tonalidad" id="tonalidad"
                                                                            class="form-select">
                                                                            <option value="" selected disabled>
                                                                                Seleccione la tonalidad</option>
                                                                            @foreach ($vidrio_tonalidades as $tonalidad)
                                                                                <option value="{{ $tonalidad->id }}">
                                                                                    {{ $tonalidad->descripcion }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="mm"
                                                                            class="form-label"><b>Medida</b></label>
                                                                        <select name="mm" id="mm"
                                                                            class="form-select">
                                                                            <option value="" selected disabled>
                                                                                Seleccione la medida (mm)</option>
                                                                            @foreach ($vidrio_mm as $mm)
                                                                                <option value="{{ $mm->id }}">
                                                                                    {{ $mm->mm }}</option>
                                                                            @endforeach
                                                                        </select>
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

                                            <div class="row mb-4">
                                                <div class="col-md-4 ms-3">
                                                    <label for="filtroTonalidad"
                                                        class="form-label fw-bold">Tonalidad:</label>
                                                    <select id="filtroTonalidad"
                                                        class="form-select bg-light border-success">
                                                        <option value="">Todos los registros</option>
                                                        @foreach ($tipos_tonalidades->unique('tonalidad') as $producto)
                                                            <option value="{{ $producto->tonalidad }}">
                                                                {{ $producto->tonalidad }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="filtroMedida" class="form-label fw-bold">Medida
                                                        (mm):</label>
                                                    <select id="filtroMedida"
                                                        class="form-select bg-light border-primary">
                                                        <option value="">Todos los registros</option>
                                                        @foreach ($tipos_tonalidades->unique('mm') as $producto)
                                                            <option value="{{ $producto->mm }}">
                                                                {{ $producto->mm }} mm</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="card-body table-responsive">
                                                <table id="tabla_vidrio" class="tablas display">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Producto</th>
                                                            <th>Medida (mm)</th>
                                                            <td>Stock disponible</td>
                                                            <th>Configuración</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($productos_vidrio as $producto_vidrio)
                                                            <tr>
                                                                <td>{{ $producto_vidrio->id }}-VID</td>
                                                                <td>{{ $producto_vidrio->tonalidad }}</td>
                                                                <td>{{ $producto_vidrio->mm }} mm</td>
                                                                <td class="align-middle">
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm text-center input-stock"
                                                                            value="{{ $producto_vidrio->hojas }}"
                                                                            readonly>

                                                                        <button type="button"
                                                                            class="btn btn-sm btn-primary"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#modalStock_{{ $producto_vidrio->id }}">
                                                                            <i class="bi bi-arrow-clockwise"></i>
                                                                        </button>

                                                                        <div class="modal fade modal-dialog-scrollable"
                                                                            id="modalStock_{{ $producto_vidrio->id }}"
                                                                            data-bs-backdrop="static"
                                                                            data-bs-keyboard="false" tabindex="-1"
                                                                            aria-labelledby="modalStock_Label"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5"
                                                                                            id="modalStock_Label">
                                                                                            Stock
                                                                                            del producto</h1>
                                                                                        <button type="button"
                                                                                            class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
                                                                                    </div>

                                                                                    <form
                                                                                        action="{{ route('vidrio_stock_product') }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <div class="modal-body">
                                                                                            <input type="hidden"
                                                                                                value="{{ $producto_vidrio->id }}"
                                                                                                name="producto_id">

                                                                                            <div class="mb-3">
                                                                                                <label for="cantidad"
                                                                                                    class="form-label"><b>Cantidad
                                                                                                        de hojas
                                                                                                        disponibles</b></label>
                                                                                                <input type="number"
                                                                                                    id="cantidad"
                                                                                                    name="cantidad"
                                                                                                    class="form-control"
                                                                                                    value="{{ $producto_vidrio->hojas ?? 0 }}"
                                                                                                    min="0">
                                                                                            </div>

                                                                                            <div class="mb-3">
                                                                                                <label
                                                                                                    for="metros_cuadrados"
                                                                                                    class="form-label"><b>Metros
                                                                                                        cuadrados
                                                                                                        equivalentes</b></label>
                                                                                                <input type="number"
                                                                                                    id="metros_cuadrados"
                                                                                                    name="metros_cuadrados"
                                                                                                    class="form-control"
                                                                                                    value="{{ $producto_vidrio->cantidad_metros_2 ?? 0 }}"
                                                                                                    readonly>
                                                                                            </div>

                                                                                            <div class="mb-3">
                                                                                                <label for="stock"
                                                                                                    class="form-label"><b>Añadir
                                                                                                        hojas al stock
                                                                                                        actual</b></label>
                                                                                                <input type="number"
                                                                                                    id="stock"
                                                                                                    name="stock"
                                                                                                    class="form-control"
                                                                                                    min="0">
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
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#modalEdit_{{ $producto_vidrio->id }}">
                                                                            <i class="bi bi-pencil-fill"></i>
                                                                        </button>
                                                                        <div class="modal fade modal-dialog-scrollable"
                                                                            id="modalEdit_{{ $producto_vidrio->id }}"
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
                                                                                        action="{{ route('vidrio_update_product') }}"
                                                                                        method="POST"
                                                                                        enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div class="modal-body">
                                                                                            <input type="hidden"
                                                                                                value="{{ $producto_vidrio->id }}"
                                                                                                name="producto_id">

                                                                                            <div class="mb-3">
                                                                                                <label for="tonalidad"
                                                                                                    class="form-label"><b>Tonalidad</b></label>
                                                                                                <select
                                                                                                    name="tonalidad"
                                                                                                    id="tonalidad_update_{{ $producto_vidrio->id }}"
                                                                                                    class="form-select">
                                                                                                    <option
                                                                                                        value="{{ $producto_vidrio->id_tonalidad }}"
                                                                                                        selected>
                                                                                                        Tonalidad
                                                                                                        actual:
                                                                                                        {{ ucfirst(str_replace('Tonalidad', '', $producto_vidrio->tonalidad)) }}
                                                                                                    </option>
                                                                                                    @foreach ($vidrio_tonalidades as $tonalidad)
                                                                                                        <option
                                                                                                            value="{{ $tonalidad->id }}">
                                                                                                            {{ $tonalidad->descripcion }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>

                                                                                            <div class="mb-3">
                                                                                                <label for="mm"
                                                                                                    class="form-label"><b>Medida
                                                                                                        (mm)</b></label>
                                                                                                <select name="mm"
                                                                                                    id="mm_update_{{ $producto_vidrio->id }}"
                                                                                                    class="form-select">
                                                                                                    <option
                                                                                                        value="{{ $producto_vidrio->id_mm }}"
                                                                                                        selected>
                                                                                                        Medida
                                                                                                        actual:
                                                                                                        {{ ucfirst(str_replace('Medida (mm)', '', $producto_vidrio->mm)) }}
                                                                                                        mm
                                                                                                    </option>
                                                                                                    @foreach ($vidrio_mm as $mm)
                                                                                                        <option
                                                                                                            value="{{ $mm->id }}">
                                                                                                            {{ $mm->mm }}
                                                                                                            mm
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>

                                                                                            <div class="mb-3">
                                                                                                <label for="imagen"
                                                                                                    class="form-label"><b>Imagen</b></label>
                                                                                                @if ($producto_vidrio->imagen)
                                                                                                    <div
                                                                                                        class="mt-2">
                                                                                                        <img src="{{ asset($producto_vidrio->imagen) }}"
                                                                                                            alt="{{ $producto_vidrio->tonalidad . ' ' . $producto_vidrio->mm }}"
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
                                                                            action="{{ route('vidrio_delete_product', $producto_vidrio->id) }}"
                                                                            method="POST" class="formEliminar">
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
<script src="{{ asset('js/table_vidrio.js') }}"></script>
