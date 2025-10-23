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
                                                <h5 class="mb-0">Gestión de productos: Aluminio</h5>

                                                <div class="d-flex gap-2 ms-auto">
                                                    <a href="{{ route('descargar.inventario.aluminio.admin') }}"
                                                        target="_blank" class="btn btn-dark"
                                                        style="text-transform: none;">
                                                        Descargar inventario
                                                    </a>

                                                    <button class="btn btn-success" style="text-transform: none;"
                                                        data-bs-toggle="modal" data-bs-target="#modalAddProduct">
                                                        Agregar producto
                                                    </button>

                                                    <a href="{{ route('gestion_aluminio_admin_show') }}" target="_blank"
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
                                                            <form action="{{ route('aluminio_add_product') }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf

                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="codigo"
                                                                            class="form-label"><b>Código</b></label>
                                                                        <input type="text" name="codigo"
                                                                            id="codigo" class="form-control" required
                                                                            maxlength="500" />
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="producto"
                                                                            class="form-label"><b>Producto</b></label>
                                                                        <input type="text" name="producto"
                                                                            id="producto" class="form-control" required
                                                                            maxlength="500" />
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="linea"
                                                                            class="form-label"><b>Línea</b></label>
                                                                        <select name="linea" id="linea"
                                                                            class="form-select" required>
                                                                            <option value="" selected disabled>
                                                                                Seleccione la línea</option>
                                                                            @foreach ($lineas_aluminio as $lineas)
                                                                                <option value="{{ $lineas->id }}">
                                                                                    {{ $lineas->descripcion }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="serie"
                                                                            class="form-label"><b>Serie</b></label>
                                                                        <select name="serie" id="serie"
                                                                            class="form-select" required>
                                                                            <option value="" selected disabled>
                                                                                Seleccione la serie</option>
                                                                            @foreach ($tipos_aluminio as $serie)
                                                                                <option value="{{ $serie->id_serie }}">
                                                                                    {{ $serie->serie }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="imagen"
                                                                            class="form-label"><b>Imagen</b></label>
                                                                        <input type="file" name="imagen"
                                                                            id="imagen" class="form-control"
                                                                            accept="image/*" />
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
                                                    <label for="filtroLinea" class="form-label fw-bold">Línea:</label>
                                                    <select id="filtroLinea"
                                                        class="form-select bg-light border-success">
                                                        <option value="">Todos los registros</option>
                                                        @foreach ($tipos_aluminio->unique('linea') as $producto)
                                                            <option value="{{ $producto->linea }}">
                                                                {{ $producto->linea }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="filtroSerie" class="form-label fw-bold">Serie:</label>
                                                    <select id="filtroSerie"
                                                        class="form-select bg-light border-primary">
                                                        <option value="" selected disabled>Seleccione la serie
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="card-body table-responsive">
                                                <table id="tabla_aluminio"class="tablas display">
                                                    <thead>
                                                        <tr>
                                                            <th>Código</th>
                                                            <th>Producto</th>
                                                            <th>Stock disponible</th>
                                                            <th>Configuración</th>
                                                            <th class="d-none">Serie</th>
                                                            <th class="d-none">Línea</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($productos_aluminio as $producto_aluminio)
                                                            <tr>
                                                                <td>{{ $producto_aluminio->codigo }}</td>
                                                                <td>{{ $producto_aluminio->producto }}</td>
                                                                <td class="align-middle">
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <input type="text"
                                                                            class="form-control form-control-sm text-center input-stock"
                                                                            value="{{ $producto_aluminio->stock_cantidad }}"
                                                                            readonly>

                                                                        <button type="button"
                                                                            class="btn btn-sm btn-primary"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#modalStock_{{ $producto_aluminio->id }}">
                                                                            <i class="bi bi-arrow-clockwise"></i>
                                                                        </button>

                                                                        <div class="modal fade modal-dialog-scrollable"
                                                                            id="modalStock_{{ $producto_aluminio->id }}"
                                                                            data-bs-backdrop="static"
                                                                            data-bs-keyboard="false" tabindex="-1"
                                                                            aria-labelledby="modalStock_Label"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5"
                                                                                            id="modalStock_Label">Stock
                                                                                            del producto</h1>
                                                                                        <button type="button"
                                                                                            class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
                                                                                    </div>

                                                                                    <form
                                                                                        action="{{ route('aluminio_stock_product') }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <div class="modal-body">
                                                                                            <input type="hidden"
                                                                                                value="{{ $producto_aluminio->id }}"
                                                                                                name="producto_id">

                                                                                            <div class="mb-3">
                                                                                                <label for="cantidad"
                                                                                                    class="form-label"><b>Cantidad
                                                                                                        de piezas
                                                                                                        disponibles</b></label>
                                                                                                <input type="number"
                                                                                                    id="cantidad"
                                                                                                    name="cantidad"
                                                                                                    class="form-control"
                                                                                                    value="{{ $producto_aluminio->stock_cantidad ?? 0 }}"
                                                                                                    min="0">
                                                                                            </div>

                                                                                            <div class="mb-3">
                                                                                                <label
                                                                                                    for="metros_lineales"
                                                                                                    class="form-label"><b>Metros
                                                                                                        lineales
                                                                                                        equivalentes</b></label>
                                                                                                <input type="number"
                                                                                                    id="metros_lineales"
                                                                                                    name="metros_lineales"
                                                                                                    class="form-control"
                                                                                                    value="{{ $producto_aluminio->metros_lienales ?? 0 }}"
                                                                                                    readonly>
                                                                                            </div>

                                                                                            <div class="mb-3">
                                                                                                <label for="stock"
                                                                                                    class="form-label"><b>Añadir
                                                                                                        piezas al stock
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
                                                                            data-bs-target="#modalEdit_{{ $producto_aluminio->id }}">
                                                                            <i class="bi bi-pencil-fill"></i>
                                                                        </button>
                                                                        <div class="modal fade modal-dialog-scrollable"
                                                                            id="modalEdit_{{ $producto_aluminio->id }}"
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
                                                                                        action="{{ route('aluminio_update_product') }}"
                                                                                        method="POST"
                                                                                        enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div class="modal-body">
                                                                                            <input type="hidden"
                                                                                                value="{{ $producto_aluminio->id }}"
                                                                                                name="producto_id">
                                                                                            <div class="mb-3">
                                                                                                <label for="codigo"
                                                                                                    class="form-label"><b>Código</b></label>
                                                                                                <input type="text"
                                                                                                    id="codigo"
                                                                                                    name="codigo"
                                                                                                    class="form-control"
                                                                                                    value="{{ $producto_aluminio->codigo }}">
                                                                                            </div>
                                                                                            <div class="mb-3">
                                                                                                <label for="producto"
                                                                                                    class="form-label"><b>Producto</b></label>
                                                                                                <input type="text"
                                                                                                    id="producto"
                                                                                                    name="producto"
                                                                                                    class="form-control"
                                                                                                    value="{{ $producto_aluminio->producto }}">
                                                                                            </div>
                                                                                            <div class="mb-3">
                                                                                                <label for="linea"
                                                                                                    class="form-label"><b>Línea</b></label>
                                                                                                <select name="linea"
                                                                                                    id="linea_update_{{ $producto_aluminio->id }}"
                                                                                                    class="form-select">
                                                                                                    <option
                                                                                                        value="{{ $producto_aluminio->id_linea }}"
                                                                                                        selected>
                                                                                                        Línea actual:
                                                                                                        {{ ucfirst(str_replace('Línea', '', $producto_aluminio->linea)) }}
                                                                                                    </option>
                                                                                                    @foreach ($lineas_aluminio as $linea)
                                                                                                        <option
                                                                                                            value="{{ $linea->id }}">
                                                                                                            {{ $linea->descripcion }}
                                                                                                        </option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="mb-3">
                                                                                                <label for="serie"
                                                                                                    class="form-label"><b>Serie</b></label>
                                                                                                <select name="serie"
                                                                                                    id="serie_update_{{ $producto_aluminio->id }}"
                                                                                                    class="form-select">
                                                                                                    <option
                                                                                                        value="{{ $producto_aluminio->id_serie }}"
                                                                                                        selected>
                                                                                                        {{ $producto_aluminio->serie }}
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="mb-3">
                                                                                                <label for="imagen"
                                                                                                    class="form-label"><b>Imagen</b></label>
                                                                                                <input type="file"
                                                                                                    id="imagen"
                                                                                                    name="imagen"
                                                                                                    class="form-control">
                                                                                                @if ($producto_aluminio->imagen)
                                                                                                    <div
                                                                                                        class="mt-2">
                                                                                                        <img src="{{ asset($producto_aluminio->imagen) }}"
                                                                                                            alt="{{ $producto_aluminio->codigo . ' ' . $producto_aluminio->producto }}"
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
                                                                            action="{{ route('aluminio_delete_product', $producto_aluminio->id) }}"
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
                                                                <td class="d-none">{{ $producto_aluminio->serie }}
                                                                </td>
                                                                <td class="d-none">{{ $producto_aluminio->linea }}
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

<script>
    window.seriesAluminio = @json($tipos_aluminio);
</script>
<script src="{{ asset('js/table_aluminio.js') }}"></script>
<script src="{{ asset('js/gestion_aluminio.js') }}"></script>
