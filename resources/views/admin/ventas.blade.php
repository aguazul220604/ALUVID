<!DOCTYPE html>
<html lang="en">

<x-header />

<body>

    <x-preloader />

    @if (session('message') === 'update')
        <script>
            Swal.fire({
                text: "Datos actualizados exitosamente",
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
                                                <h5 class="mb-0">Gestión de ventas</h5>
                                            </div>
                                            <div class="card-body">
                                                <!-- Fila con Select a la izquierda y botón a la derecha -->
                                                <form action="{{ route('reporte.ventas') }}" method="POST"
                                                    target="_blank">
                                                    @csrf
                                                    <div class="row align-items-center mb-3">
                                                        <div class="col-md-6 d-flex align-items-center">
                                                            <label for="periodoSelect"
                                                                class="form-label me-2 mb-0">Periodo de tiempo:</label>
                                                            <select id="periodoSelect" name="periodo"
                                                                class="form-select" style="width: auto;">
                                                                <option value="diario" selected>Diario</option>
                                                                <option value="semanal">Semanal</option>
                                                                <option value="mensual">Mensual</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 text-end">
                                                            <button id="descargarReporte" type="submit" target="_blank"
                                                                class="btn btn-dark" style="text-transform: none;">
                                                                Descargar reporte
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>

                                                <!-- Contenedor de la gráfica -->
                                                <canvas id="ventasChart" height="100"></canvas>
                                                <!-- Chart.js -->
                                                <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
                                                <script>
                                                    const ctx = document.getElementById('ventasChart').getContext('2d');

                                                    let ventasChart = new Chart(ctx, {
                                                        type: 'bar',
                                                        data: {
                                                            labels: ['Inversión', 'Ventas', 'Ganancia'],
                                                            datasets: [{
                                                                label: 'Totales',
                                                                data: [0, 0, 0], // Inicial
                                                                backgroundColor: ['#f39c12', '#3498db', '#2ecc71'],
                                                                borderWidth: 1
                                                            }]
                                                        },
                                                        options: {
                                                            responsive: true,
                                                            scales: {
                                                                y: {
                                                                    beginAtZero: true,
                                                                    ticks: {
                                                                        callback: function(value) {
                                                                            return '$' + value.toLocaleString();
                                                                        }
                                                                    }
                                                                }
                                                            },
                                                            plugins: {
                                                                tooltip: {
                                                                    callbacks: {
                                                                        label: function(context) {
                                                                            return '$' + context.parsed.y.toLocaleString();
                                                                        }
                                                                    }
                                                                },
                                                                legend: {
                                                                    display: false
                                                                },
                                                                title: {
                                                                    display: true,
                                                                    text: 'Resumen Diario de Ventas'
                                                                }
                                                            }
                                                        }
                                                    });

                                                    async function cargarDatosGrafica(periodo) {
                                                        try {
                                                            const response = await fetch(`/api/ventas/estadisticas?periodo=${periodo}`);
                                                            const data = await response.json();

                                                            ventasChart.data.datasets[0].data = [
                                                                data.inversionTotal || 0,
                                                                data.ventaTotal || 0,
                                                                data.gananciaTotal || 0
                                                            ];

                                                            ventasChart.options.plugins.title.text = 'Resumen ' + periodo.charAt(0).toUpperCase() + periodo.slice(
                                                                1) + ' de Ventas';
                                                            ventasChart.update();
                                                        } catch (error) {
                                                            console.error('Error al cargar datos:', error);
                                                        }
                                                    }

                                                    // Cargar datos iniciales
                                                    cargarDatosGrafica('diario');

                                                    document.getElementById('periodoSelect').addEventListener('change', function() {
                                                        cargarDatosGrafica(this.value);
                                                    });
                                                </script>

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
                                                                <th>Acciones</th>
                                                                <th>Actualización</th>
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
                                                                            10%
                                                                        @elseif ($venta->id_descuento == 1)
                                                                            15%
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
                                                                                                    ) ?? [],
                                                                                                )->groupBy('idc');

                                                                                                $aluminios = (
                                                                                                    $productos[1] ??
                                                                                                    collect()
                                                                                                )->filter(
                                                                                                    fn($p) => ($p[
                                                                                                        'cantidad'
                                                                                                    ] ??
                                                                                                        0) >
                                                                                                        0,
                                                                                                );

                                                                                                $herrajes = (
                                                                                                    $productos[2] ??
                                                                                                    collect()
                                                                                                )->filter(
                                                                                                    fn($p) => ($p[
                                                                                                        'cantidad'
                                                                                                    ] ??
                                                                                                        0) >
                                                                                                        0,
                                                                                                );

                                                                                                $vidrios = (
                                                                                                    $productos[3] ??
                                                                                                    collect()
                                                                                                )->filter(
                                                                                                    fn($p) => ($p[
                                                                                                        'cantidad'
                                                                                                    ] ??
                                                                                                        0) >
                                                                                                        0,
                                                                                                );
                                                                                            @endphp


                                                                                            {{-- Aluminio --}}
                                                                                            @if ($aluminios->isNotEmpty())
                                                                                                <h5
                                                                                                    class="mt-3 text-primary">
                                                                                                    Aluminio</h5>
                                                                                                <table
                                                                                                    class="table table-bordered w-100 text-center align-middle fixed-table">
                                                                                                    <colgroup>
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                    </colgroup>
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
                                                                                                        @foreach ($aluminios as $p)
                                                                                                            <tr>
                                                                                                                <td>{{ $p['codigo'] ?? '' }}
                                                                                                                </td>
                                                                                                                <td>{{ $p['producto'] ?? '' }}
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    @if (!empty($p['imagen']))
                                                                                                                        <img src="{{ $p['imagen'] }}"
                                                                                                                            alt="img"
                                                                                                                            style="width: 60px; height: 60px;">
                                                                                                                    @endif
                                                                                                                </td>
                                                                                                                <td>{{ isset($p['preciop']) ? '$' . number_format($p['preciop'], 2) : '' }}
                                                                                                                </td>
                                                                                                                <td>{{ $p['cantidad'] ?? '' }}
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endforeach
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            @endif

                                                                                            {{-- Herrajes --}}
                                                                                            @if ($herrajes->isNotEmpty())
                                                                                                <h5
                                                                                                    class="mt-3 text-primary">
                                                                                                    Herrajes</h5>
                                                                                                <table
                                                                                                    class="table table-bordered w-100 text-center align-middle fixed-table">
                                                                                                    <colgroup>
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                    </colgroup>
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
                                                                                                        @foreach ($herrajes as $p)
                                                                                                            <tr>
                                                                                                                <td>{{ $p['codigo'] ?? '' }}
                                                                                                                </td>
                                                                                                                <td>{{ $p['producto'] ?? '' }}
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    @if (!empty($p['imagen']))
                                                                                                                        <img src="{{ $p['imagen'] }}"
                                                                                                                            alt="img"
                                                                                                                            style="width: 60px; height: 60px;">
                                                                                                                    @endif
                                                                                                                </td>
                                                                                                                <td>{{ isset($p['precio']) ? '$' . number_format($p['precio'], 2) : '' }}
                                                                                                                </td>
                                                                                                                <td>{{ $p['cantidad'] ?? '' }}
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endforeach
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            @endif

                                                                                            {{-- Vidrio --}}
                                                                                            @if ($vidrios->isNotEmpty())
                                                                                                <h5
                                                                                                    class="mt-3 text-primary">
                                                                                                    Vidrio</h5>
                                                                                                <table
                                                                                                    class="table table-bordered w-100 text-center align-middle fixed-table">
                                                                                                    <colgroup>
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                        <col
                                                                                                            style="width: 20%">
                                                                                                    </colgroup>
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
                                                                                                        @foreach ($vidrios as $p)
                                                                                                            <tr>
                                                                                                                <td>{{ $p['id'] ?? '' }}-VID
                                                                                                                </td>
                                                                                                                <td>{{ ($p['tonalidad'] ?? '') . ' ' . ($p['mm'] ?? '') . ' mm' }}
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    @if (!empty($p['imagen']))
                                                                                                                        <img src="{{ $p['imagen'] }}"
                                                                                                                            alt="img"
                                                                                                                            style="width: 60px; height: 60px;">
                                                                                                                    @endif
                                                                                                                </td>
                                                                                                                <td>{{ isset($p['precioh']) ? '$' . number_format($p['precioh'], 2) : '' }}
                                                                                                                </td>
                                                                                                                <td>{{ $p['cantidad'] ?? '' }}
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

                                                                            <form
                                                                                action="{{ route('venta_delete', $venta->id) }}"
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
                                                                    <td>
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <button type="button"
                                                                                class="btn btn-sm btn-primary"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#modalUpdate_{{ $venta->id }}">
                                                                                <i class="bi bi-arrow-clockwise"></i>
                                                                            </button>

                                                                            @if (!is_null($venta->diferencia))
                                                                                <a href="{{ route('reporte_venta_update', $venta->id) }}"
                                                                                    class="btn btn-sm btn-success"
                                                                                    title="Descargar diferencia">
                                                                                    <i
                                                                                        class="bi bi-file-earmark-text"></i>
                                                                                </a>
                                                                            @else
                                                                                <button
                                                                                    class="btn btn-sm btn-secondary"
                                                                                    disabled title="Sin diferencia">
                                                                                    <i class="bi bi-x-lg"></i>
                                                                                </button>
                                                                            @endif

                                                                            <div class="modal fade modal-dialog-scrollable"
                                                                                id="modalUpdate_{{ $venta->id }}"
                                                                                data-bs-backdrop="static"
                                                                                data-bs-keyboard="false"
                                                                                tabindex="-1"
                                                                                aria-labelledby="modalUpdate_Label"
                                                                                aria-hidden="true">
                                                                                <div class="modal-dialog modal-xl">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h1 class="modal-title fs-5"
                                                                                                id="modalUpdate_Label">
                                                                                                Actualizar venta
                                                                                            </h1>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>

                                                                                        <form
                                                                                            action="{{ route('ventas_update', $venta->id) }}"
                                                                                            method="POST">
                                                                                            @csrf

                                                                                            <div class="modal-body"
                                                                                                style="max-height: 70vh; overflow-y: auto;">
                                                                                                @php
                                                                                                    $productosData =
                                                                                                        json_decode(
                                                                                                            $venta->productos,
                                                                                                            true,
                                                                                                        ) ?? [];
                                                                                                    $productos = collect(
                                                                                                        $productosData,
                                                                                                    )->groupBy('idc');

                                                                                                    // Filtrar productos con cantidad > 0
                                                                                                    $aluminios = (
                                                                                                        $productos[1] ??
                                                                                                        collect()
                                                                                                    )->filter(
                                                                                                        fn($p) => ($p[
                                                                                                            'cantidad'
                                                                                                        ] ??
                                                                                                            0) >
                                                                                                            0,
                                                                                                    );

                                                                                                    $herrajes = (
                                                                                                        $productos[2] ??
                                                                                                        collect()
                                                                                                    )->filter(
                                                                                                        fn($p) => ($p[
                                                                                                            'cantidad'
                                                                                                        ] ??
                                                                                                            0) >
                                                                                                            0,
                                                                                                    );

                                                                                                    $vidrios = (
                                                                                                        $productos[3] ??
                                                                                                        collect()
                                                                                                    )->filter(
                                                                                                        fn($p) => ($p[
                                                                                                            'cantidad'
                                                                                                        ] ??
                                                                                                            0) >
                                                                                                            0,
                                                                                                    );
                                                                                                @endphp


                                                                                                {{-- Aluminio --}}
                                                                                                @if ($aluminios->isNotEmpty())
                                                                                                    <h5
                                                                                                        class="mt-3 text-primary">
                                                                                                        Aluminio</h5>
                                                                                                    <table
                                                                                                        class="table table-bordered w-100 text-center align-middle fixed-table">
                                                                                                        <colgroup>
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                            <col
                                                                                                                style="width: 25%">
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                        </colgroup>
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
                                                                                                                    unit.
                                                                                                                </th>
                                                                                                                <th>Cantidad
                                                                                                                </th>
                                                                                                                <th>Total
                                                                                                                </th>
                                                                                                            </tr>
                                                                                                        </thead>
                                                                                                        <tbody>
                                                                                                            @foreach ($aluminios as $i => $p)
                                                                                                                @php
                                                                                                                    $precio =
                                                                                                                        $p[
                                                                                                                            'preciop'
                                                                                                                        ] ??
                                                                                                                        ($p[
                                                                                                                            'precio'
                                                                                                                        ] ??
                                                                                                                            ($p[
                                                                                                                                'precioh'
                                                                                                                            ] ??
                                                                                                                                0));
                                                                                                                    $cantidad =
                                                                                                                        $p[
                                                                                                                            'cantidad'
                                                                                                                        ] ??
                                                                                                                        0;
                                                                                                                @endphp
                                                                                                                <tr>
                                                                                                                    <td>{{ $p['codigo'] ?? '' }}
                                                                                                                    </td>
                                                                                                                    <td>{{ $p['producto'] ?? '' }}
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        @if (!empty($p['imagen']))
                                                                                                                            <img src="{{ $p['imagen'] }}"
                                                                                                                                alt="img"
                                                                                                                                style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc;">
                                                                                                                        @endif
                                                                                                                    </td>
                                                                                                                    <td>$
                                                                                                                        <input
                                                                                                                            type="number"
                                                                                                                            name="productos[1][{{ $i }}][precio]"
                                                                                                                            class="form-control precio"
                                                                                                                            step="0.01"
                                                                                                                            value="{{ $precio }}"
                                                                                                                            readonly>
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <input
                                                                                                                            type="number"
                                                                                                                            name="productos[1][{{ $i }}][cantidad]"
                                                                                                                            class="form-control cantidad"
                                                                                                                            min="0"
                                                                                                                            max="{{ $cantidad }}"
                                                                                                                            value="{{ $cantidad }}">
                                                                                                                    </td>

                                                                                                                    <td
                                                                                                                        class="total">
                                                                                                                        ${{ number_format($precio * $cantidad, 2) }}
                                                                                                                    </td>

                                                                                                                    {{-- Campos ocultos --}}
                                                                                                                    <input
                                                                                                                        type="hidden"
                                                                                                                        name="productos[1][{{ $i }}][id]"
                                                                                                                        value="{{ $p['id'] ?? '' }}">
                                                                                                                    <input
                                                                                                                        type="hidden"
                                                                                                                        name="productos[1][{{ $i }}][codigo]"
                                                                                                                        value="{{ $p['codigo'] ?? '' }}">
                                                                                                                    <input
                                                                                                                        type="hidden"
                                                                                                                        name="productos[1][{{ $i }}][producto]"
                                                                                                                        value="{{ $p['producto'] ?? '' }}">
                                                                                                                    <input
                                                                                                                        type="hidden"
                                                                                                                        name="productos[1][{{ $i }}][imagen]"
                                                                                                                        value="{{ $p['imagen'] ?? '' }}">
                                                                                                                </tr>
                                                                                                            @endforeach
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                @endif

                                                                                                {{-- Herrajes --}}
                                                                                                @if ($herrajes->isNotEmpty())
                                                                                                    <h5
                                                                                                        class="mt-3 text-primary">
                                                                                                        Herrajes</h5>
                                                                                                    <table
                                                                                                        class="table table-bordered w-100 text-center align-middle fixed-table">
                                                                                                        <colgroup>
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                            <col
                                                                                                                style="width: 25%">
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                        </colgroup>
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
                                                                                                                    unit.
                                                                                                                </th>
                                                                                                                <th>Cantidad
                                                                                                                </th>
                                                                                                                <th>Total
                                                                                                                </th>
                                                                                                            </tr>
                                                                                                        </thead>
                                                                                                        <tbody>
                                                                                                            @foreach ($herrajes as $i => $p)
                                                                                                                @php
                                                                                                                    $precio =
                                                                                                                        $p[
                                                                                                                            'precio'
                                                                                                                        ] ??
                                                                                                                        ($p[
                                                                                                                            'preciop'
                                                                                                                        ] ??
                                                                                                                            ($p[
                                                                                                                                'precioh'
                                                                                                                            ] ??
                                                                                                                                0));
                                                                                                                    $cantidad =
                                                                                                                        $p[
                                                                                                                            'cantidad'
                                                                                                                        ] ??
                                                                                                                        0;
                                                                                                                @endphp
                                                                                                                <tr>
                                                                                                                    <td>{{ $p['codigo'] ?? '' }}
                                                                                                                    </td>
                                                                                                                    <td>{{ $p['producto'] ?? '' }}
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        @if (!empty($p['imagen']))
                                                                                                                            <img src="{{ $p['imagen'] }}"
                                                                                                                                alt="img"
                                                                                                                                style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc;">
                                                                                                                        @endif
                                                                                                                    </td>
                                                                                                                    <td>$
                                                                                                                        <input
                                                                                                                            type="number"
                                                                                                                            name="productos[2][{{ $i }}][precio]"
                                                                                                                            class="form-control precio"
                                                                                                                            step="0.01"
                                                                                                                            value="{{ $precio }}"
                                                                                                                            readonly>
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <input
                                                                                                                            type="number"
                                                                                                                            name="productos[2][{{ $i }}][cantidad]"
                                                                                                                            class="form-control cantidad"
                                                                                                                            min="0"
                                                                                                                            max="{{ $cantidad }}"
                                                                                                                            value="{{ $cantidad }}">
                                                                                                                    </td>
                                                                                                                    <td
                                                                                                                        class="total">
                                                                                                                        ${{ number_format($precio * $cantidad, 2) }}
                                                                                                                    </td>

                                                                                                                    <input
                                                                                                                        type="hidden"
                                                                                                                        name="productos[2][{{ $i }}][id]"
                                                                                                                        value="{{ $p['id'] ?? '' }}">
                                                                                                                    <input
                                                                                                                        type="hidden"
                                                                                                                        name="productos[2][{{ $i }}][codigo]"
                                                                                                                        value="{{ $p['codigo'] ?? '' }}">
                                                                                                                    <input
                                                                                                                        type="hidden"
                                                                                                                        name="productos[2][{{ $i }}][producto]"
                                                                                                                        value="{{ $p['producto'] ?? '' }}">
                                                                                                                    <input
                                                                                                                        type="hidden"
                                                                                                                        name="productos[2][{{ $i }}][imagen]"
                                                                                                                        value="{{ $p['imagen'] ?? '' }}">
                                                                                                                </tr>
                                                                                                            @endforeach
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                @endif

                                                                                                {{-- Vidrio --}}
                                                                                                @if ($vidrios->isNotEmpty())
                                                                                                    <h5
                                                                                                        class="mt-3 text-primary">
                                                                                                        Vidrio</h5>
                                                                                                    <table
                                                                                                        class="table table-bordered w-100 text-center align-middle fixed-table">
                                                                                                        <colgroup>
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                            <col
                                                                                                                style="width: 25%">
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                            <col
                                                                                                                style="width: 15%">
                                                                                                        </colgroup>
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
                                                                                                                    unit.
                                                                                                                </th>
                                                                                                                <th>Cantidad
                                                                                                                </th>
                                                                                                                <th>Total
                                                                                                                </th>
                                                                                                            </tr>
                                                                                                        </thead>
                                                                                                        <tbody>
                                                                                                            @foreach ($vidrios as $i => $p)
                                                                                                                @php
                                                                                                                    $precio =
                                                                                                                        $p[
                                                                                                                            'precioh'
                                                                                                                        ] ??
                                                                                                                        ($p[
                                                                                                                            'precio'
                                                                                                                        ] ??
                                                                                                                            ($p[
                                                                                                                                'preciop'
                                                                                                                            ] ??
                                                                                                                                0));
                                                                                                                    $cantidad =
                                                                                                                        $p[
                                                                                                                            'cantidad'
                                                                                                                        ] ??
                                                                                                                        0;
                                                                                                                @endphp
                                                                                                                <tr>
                                                                                                                    <td>{{ $p['id'] ?? '' }}-VID
                                                                                                                    </td>
                                                                                                                    <td>{{ ($p['tonalidad'] ?? '') . ' ' . ($p['mm'] ?? '') }}
                                                                                                                        mm
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        @if (!empty($p['imagen']))
                                                                                                                            <img src="{{ $p['imagen'] }}"
                                                                                                                                alt="img"
                                                                                                                                style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc;">
                                                                                                                        @endif
                                                                                                                    </td>
                                                                                                                    <td>$
                                                                                                                        <input
                                                                                                                            type="number"
                                                                                                                            name="productos[3][{{ $i }}][precio]"
                                                                                                                            class="form-control precio"
                                                                                                                            step="0.01"
                                                                                                                            value="{{ $precio }}"
                                                                                                                            readonly>
                                                                                                                    </td>
                                                                                                                    <td>
                                                                                                                        <input
                                                                                                                            type="number"
                                                                                                                            name="productos[3][{{ $i }}][cantidad]"
                                                                                                                            class="form-control cantidad"
                                                                                                                            min="0"
                                                                                                                            max="{{ $cantidad }}"
                                                                                                                            value="{{ $cantidad }}">
                                                                                                                    </td>
                                                                                                                    <td
                                                                                                                        class="total">
                                                                                                                        ${{ number_format($precio * $cantidad, 2) }}
                                                                                                                    </td>

                                                                                                                    <input
                                                                                                                        type="hidden"
                                                                                                                        name="productos[3][{{ $i }}][id]"
                                                                                                                        value="{{ $p['id'] ?? '' }}">
                                                                                                                    <input
                                                                                                                        type="hidden"
                                                                                                                        name="productos[3][{{ $i }}][imagen]"
                                                                                                                        value="{{ $p['imagen'] ?? '' }}">
                                                                                                                    <input
                                                                                                                        type="hidden"
                                                                                                                        name="productos[3][{{ $i }}][tonalidad]"
                                                                                                                        value="{{ $p['tonalidad'] ?? '' }}">
                                                                                                                    <input
                                                                                                                        type="hidden"
                                                                                                                        name="productos[3][{{ $i }}][mm]"
                                                                                                                        value="{{ $p['mm'] ?? '' }}">
                                                                                                                </tr>
                                                                                                            @endforeach
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                @endif
                                                                                            </div>

                                                                                            <div class="modal-footer">
                                                                                                <button type="button"
                                                                                                    class="btn btn-secondary"
                                                                                                    data-bs-dismiss="modal">Cancelar</button>
                                                                                                <button type="submit"
                                                                                                    class="btn btn-primary"
                                                                                                    id="btn_actualizar_{{ $venta->id }}">Actualizar</button>
                                                                                            </div>
                                                                                        </form>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    {{-- Script global para todos los formularios --}}
                                                                    <script>
                                                                        document.addEventListener("DOMContentLoaded", function() {
                                                                            document.querySelectorAll("form").forEach(form => {
                                                                                form.addEventListener("input", function(e) {
                                                                                    if (e.target.classList.contains("precio") || e.target.classList.contains(
                                                                                            "cantidad")) {
                                                                                        const row = e.target.closest("tr");
                                                                                        const precio = parseFloat(row.querySelector(".precio").value) || 0;
                                                                                        const cantidad = parseInt(row.querySelector(".cantidad").value) || 0;
                                                                                        const totalCell = row.querySelector(".total");

                                                                                        totalCell.textContent = "$" + (precio * cantidad).toFixed(2);
                                                                                    }
                                                                                });
                                                                            });
                                                                        });
                                                                    </script>

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

<script src="{{ asset('js/table_ventas.js') }}"></script>
