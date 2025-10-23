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
                                                <h5 class="mb-0">Consulta de ventas</h5>
                                            </div>

                                            <div class="card-body">
                                                <div class="row mb-4">
                                                    <div class="col-md-4 ms-3">
                                                        <label for="filtroFecha" class="form-label fw-bold">Filtrar
                                                            por:</label>
                                                        <select id="filtroFecha" class="form-select w-auto">
                                                            <option value="">Todas las ventas</option>
                                                            <option value="dia">Hoy</option>
                                                            <option value="semana">Esta semana</option>
                                                            <option value="mes">Este mes</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="card-body table-responsive">
                                                    <table id="tabla_ventas"class="tablas display">
                                                        <thead>
                                                            <tr>
                                                                <th>Folio</th>
                                                                <th>Cliente</th>
                                                                <th>Contacto</th>
                                                                <th>Subtotal Aluminio</th>
                                                                <th>Subtotal Herrajes</th>
                                                                <th>Subtotal Vidrios</th>
                                                                <th>Total</th>
                                                                <th>Descuento</th>
                                                                <th>Fecha de solicitud</th>
                                                                <th>Fecha de entrega</th>
                                                                <th>Productos</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($ventas as $venta)
                                                                <tr>
                                                                    <td>{{ $venta->id }}</td>
                                                                    <td>{{ $venta->nombre_cliente }}
                                                                        {{ $venta->apellido_cliente }}</td>
                                                                    <td>{{ $venta->contacto }}</td>
                                                                    <td>${{ number_format($venta->subtotal_aluminio, 2) }}
                                                                    </td>
                                                                    <td>${{ number_format($venta->subtotal_herrajes, 2) }}
                                                                    </td>
                                                                    <td>${{ number_format($venta->subtotal_vidrio, 2) }}
                                                                    </td>
                                                                    <td><strong>${{ number_format($venta->total, 2) }}</strong>
                                                                    </td>

                                                                    <td>
                                                                        @if ($venta->id_descuento == 3)
                                                                            0%
                                                                        @elseif ($venta->id_descuento == 2)
                                                                            5%
                                                                        @elseif ($venta->id_descuento == 1)
                                                                            10%
                                                                        @else
                                                                            No aplica
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $venta->fecha_solicitud }}</td>
                                                                    <td>{{ $venta->fecha_entrega }}</td>
                                                                    <td class="align-middle">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-primary"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#modalStock_{{ $venta->id }}">
                                                                                <i class="bi bi-info-circle-fill"></i>
                                                                                Detalles
                                                                            </button>

                                                                            <div class="modal fade modal-dialog-scrollable"
                                                                                id="modalStock_{{ $venta->id }}"
                                                                                data-bs-backdrop="static"
                                                                                data-bs-keyboard="false" tabindex="-1"
                                                                                aria-labelledby="modalStock_Label"
                                                                                aria-hidden="true">
                                                                                <div class="modal-dialog modal-xl">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h1 class="modal-title fs-5"
                                                                                                id="modalStock_Label">
                                                                                                Información de los
                                                                                                productos
                                                                                                vendidos
                                                                                            </h1>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body"
                                                                                            style="max-height: 70vh; overflow-y: auto;">
                                                                                            @php
                                                                                                $productos = collect(
                                                                                                    json_decode(
                                                                                                        $venta->productos,
                                                                                                        true,
                                                                                                    ),
                                                                                                )->groupBy('idc');
                                                                                            @endphp
                                                                                            {{-- IDC 1: Aluminio --}}
                                                                                            @if ($productos->has(1))
                                                                                                <h5
                                                                                                    class="mt-3 text-primary">
                                                                                                    Aluminio
                                                                                                </h5>
                                                                                                <table
                                                                                                    class="table table-bordered w-100">
                                                                                                    <thead
                                                                                                        class="table-light">
                                                                                                        <tr>
                                                                                                            <th>Código
                                                                                                            </th>
                                                                                                            <th>Producto
                                                                                                            </th>
                                                                                                            <th>Imagen
                                                                                                            </th>
                                                                                                            <th>Precio
                                                                                                            </th>
                                                                                                            <th>Cantidad
                                                                                                            </th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        @foreach ($productos[1] as $p)
                                                                                                            <tr>
                                                                                                                <td>{{ $p['codigo'] }}
                                                                                                                </td>
                                                                                                                <td>{{ $p['producto'] }}
                                                                                                                </td>
                                                                                                                <td><img src="{{ $p['imagen'] }}"
                                                                                                                        alt="img"
                                                                                                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc;">
                                                                                                                </td>
                                                                                                                <td>${{ number_format($p['preciop'], 2) }}
                                                                                                                </td>
                                                                                                                <td>{{ $p['cantidad'] }}
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endforeach
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            @endif

                                                                                            {{-- IDC 2: Herrajes --}}
                                                                                            @if ($productos->has(2))
                                                                                                <h5
                                                                                                    class="mt-3 text-primary">
                                                                                                    Herrajes
                                                                                                </h5>
                                                                                                <table
                                                                                                    class="table table-bordered w-100">
                                                                                                    <thead
                                                                                                        class="table-light">
                                                                                                        <tr>
                                                                                                            <th>Código
                                                                                                            </th>
                                                                                                            <th>Producto
                                                                                                            </th>
                                                                                                            <th>Imagen
                                                                                                            </th>
                                                                                                            <th>Precio
                                                                                                            </th>
                                                                                                            <th>Cantidad
                                                                                                            </th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        @foreach ($productos[2] as $p)
                                                                                                            <tr>
                                                                                                                <td>{{ $p['codigo'] }}
                                                                                                                </td>
                                                                                                                <td>{{ $p['producto'] }}
                                                                                                                </td>
                                                                                                                <td><img src="{{ $p['imagen'] }}"
                                                                                                                        alt="img"
                                                                                                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc;">
                                                                                                                </td>
                                                                                                                <td>${{ number_format($p['precio'], 2) }}
                                                                                                                </td>
                                                                                                                <td>{{ $p['cantidad'] }}
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endforeach
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            @endif

                                                                                            {{-- IDC 3: Vidrio --}}
                                                                                            @if ($productos->has(3))
                                                                                                <h5
                                                                                                    class="mt-3 text-primary">
                                                                                                    Vidrio</h5>
                                                                                                <table
                                                                                                    class="table table-bordered w-100">
                                                                                                    <thead
                                                                                                        class="table-light">
                                                                                                        <tr>
                                                                                                            <th>Código
                                                                                                            </th>
                                                                                                            <th>Vidrio
                                                                                                            </th>
                                                                                                            <th>Imagen
                                                                                                            </th>
                                                                                                            <th>Precio
                                                                                                            </th>
                                                                                                            <th>Cantidad
                                                                                                            </th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        @foreach ($productos[3] as $p)
                                                                                                            <tr>
                                                                                                                <td>{{ $p['id'] }}-VID
                                                                                                                </td>
                                                                                                                <td>{{ $p['tonalidad'] }}
                                                                                                                    {{ $p['mm'] }}
                                                                                                                    mm
                                                                                                                </td>
                                                                                                                <td><img src="{{ $p['imagen'] }}"
                                                                                                                        alt="img"
                                                                                                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc;">
                                                                                                                </td>
                                                                                                                <td>${{ number_format($p['precioh'], 2) }}
                                                                                                                </td>
                                                                                                                <td>{{ $p['cantidad'] }}
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endforeach
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            @endif

                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-bs-dismiss="modal">Cerrar</button>
                                                                                        </div>
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
    </div>

    <x-footer />

</body>

</html>

<script src="{{ asset('js/table_ventas_colab.js') }}"></script>
