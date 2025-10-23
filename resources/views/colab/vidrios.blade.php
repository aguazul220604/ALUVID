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
                                                <h5 class="mb-0">Consulta de productos: Vidrios</h5>

                                                <div class="d-flex gap-2 ms-auto">
                                                    <a href="{{ route('descargar.inventario.vidrio') }}" target="_blank"
                                                        class="btn btn-dark" style="text-transform: none;">
                                                        Descargar inventario
                                                    </a>
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
                                                            <th>Tonalidad</th>
                                                            <th>Medida (mm)</th>
                                                            <th>Imagen</th>
                                                            <td>Stock disponible</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($productos_vidrio as $producto_vidrio)
                                                            <tr>
                                                                <td>{{ $producto_vidrio->id }}-VID</td>
                                                                <td>{{ $producto_vidrio->tonalidad }}</td>
                                                                <td>{{ $producto_vidrio->mm }} mm</td>
                                                                <td><img src="{{ asset($producto_vidrio->imagen) }}"
                                                                        alt=""
                                                                        style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc;">
                                                                </td>
                                                                <td>{{ $producto_vidrio->hojas }} hojas <br>
                                                                    ({{ $producto_vidrio->cantidad_metros_2 }} metros
                                                                    cuadrados)
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
<script src="{{ asset('js/table_vidrio_colab.js') }}"></script>
