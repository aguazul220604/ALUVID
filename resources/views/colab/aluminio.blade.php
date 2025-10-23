<!DOCTYPE html>
<html lang="en">

<x-header-colab />

<body>

    <x-preloader />

    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <x-topbar-colab :user="$user" />

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">

                    <x-navbar-colab />

                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Panel gerencial</h5>
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
                                                <h5 class="mb-0">Consulta de productos: Aluminio</h5>

                                                <div class="d-flex gap-2 ms-auto">
                                                    <a href="{{ route('descargar.inventario.aluminio') }}"
                                                        target="_blank" class="btn btn-dark"
                                                        style="text-transform: none;">
                                                        Descargar inventario
                                                    </a>
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
                                                            <th>Imagen</th>
                                                            <th>Stock disponible</th>
                                                            <th>Serie</th>
                                                            <th>Línea</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($productos_aluminio as $producto_aluminio)
                                                            <tr>
                                                                <td>{{ $producto_aluminio->codigo }}</td>
                                                                <td>{{ $producto_aluminio->producto }}</td>
                                                                <td><img src="{{ asset($producto_aluminio->imagen) }}"
                                                                        alt=""
                                                                        style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc;">
                                                                </td>
                                                                <td>{{ $producto_aluminio->stock_cantidad }} piezas <br>
                                                                    ({{ $producto_aluminio->metros }} metros lineales)
                                                                </td>
                                                                <td>{{ $producto_aluminio->serie }}
                                                                </td>
                                                                <td>{{ $producto_aluminio->linea }}
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
<script src="{{ asset('js/table_aluminio_colab.js') }}"></script>
