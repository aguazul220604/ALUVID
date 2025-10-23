<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .datos-negocio {
            text-align: right;
            font-size: 11px;
        }

        .logo {
            height: 60px;
        }

        .totales {
            margin-top: 20px;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <div class="encabezado">
        <div>
            <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
        </div>
        <div style="text-align: center;">
            <h3>ALUVID IXMIQUILPAN</h3>
        </div>
        <div class="datos-negocio">
            <p>Lib. a Cardonal, San Nicolás</p>
            <p>42302 Ixmiquilpan, Hgo.</p>
            <p>Email: aluvidixmiquilpan@gmail.com</p>
            <p>Tel: 7712003391</p>
        </div>
    </div>

    <hr>

    {{-- Información del cliente --}}
    <h4 style="margin-bottom: 8px;">Resumen de Pedido</h4>
    <ul style="padding-left: 20px; margin: 0; font-size: 12px; line-height: 1.2;">
        <li style="margin-bottom: 4px;">
            <p style="margin: 0;"><strong>Cliente:</strong> {{ $venta->nombre_cliente }} {{ $venta->apellido_cliente }}
            </p>
        </li>
        <li style="margin-bottom: 4px;">
            <p style="margin: 0;"><strong>Teléfono:</strong> {{ $venta->contacto }}</p>
        </li>
        <li style="margin-bottom: 4px;">
            <p style="margin: 0;"><strong>Fecha de solicitud:</strong>
                {{ \Carbon\Carbon::parse($venta->fecha_solicitud)->format('d/m/Y') }}</p>
        </li>
        <li style="margin-bottom: 4px;">
            <p style="margin: 0;"><strong>Fecha de entrega:</strong>
                {{ \Carbon\Carbon::parse($venta->fecha_entrega)->format('d/m/Y') }}</p>
        </li>
        <li style="margin-bottom: 4px;">
            <p style="margin: 0;">
                <strong>Hora de entrega:</strong>
                {{ \Carbon\Carbon::parse($venta->hora_entrega)->format('h:i A') }}
            </p>
        </li>
        <li style="margin-bottom: 4px;">
            <p style="margin: 0;"><strong>Folio:</strong> {{ $venta->id }}</p>
        </li>
    </ul>


    {{-- Tabla de productos --}}
    <h4>Detalle de Productos</h4>
    @if (collect($productos)->where('idc', 1)->count())
        <h5>Productos de Aluminio</h5>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
            <thead style="background-color: #001d4a; color: white;">
                <tr>
                    <th style="border: 1px solid #000; padding: 5px;">Producto</th>
                    <th style="border: 1px solid #000; padding: 5px;">Cantidad</th>
                    <th style="border: 1px solid #000; padding: 5px;">Precio Unitario</th>
                    <th style="border: 1px solid #000; padding: 5px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $p)
                    @if ($p['idc'] == 1)
                        @php
                            $precio = $p['preciop'] ?? 0;
                            $subtotal = $p['cantidad'] * $precio;
                            $nombre = $p['producto'] ?? 'Producto';
                        @endphp
                        <tr>
                            <td style="border: 1px solid #000; padding: 5px;">{{ $nombre }}</td>
                            <td style="border: 1px solid #000; padding: 5px;">{{ $p['cantidad'] }}</td>
                            <td style="border: 1px solid #000; padding: 5px;">${{ number_format($precio, 2) }}</td>
                            <td style="border: 1px solid #000; padding: 5px;">${{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <p><strong>Subtotal Aluminio:</strong> ${{ number_format($venta->subtotal_aluminio, 2) }}</p>
    @endif

    {{-- Herrajes --}}
    @if (collect($productos)->where('idc', 2)->count())
        <h5>Productos de Herrajes</h5>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
            <thead style="background-color: #001d4a; color: white;">
                <tr>
                    <th style="border: 1px solid #000; padding: 5px;">Producto</th>
                    <th style="border: 1px solid #000; padding: 5px;">Cantidad</th>
                    <th style="border: 1px solid #000; padding: 5px;">Precio Unitario</th>
                    <th style="border: 1px solid #000; padding: 5px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $p)
                    @if ($p['idc'] == 2)
                        @php
                            $precio = $p['precio'] ?? 0;
                            $subtotal = $p['cantidad'] * $precio;
                            $nombre = $p['producto'] ?? 'Producto';
                        @endphp
                        <tr>
                            <td style="border: 1px solid #000; padding: 5px;">{{ $nombre }}</td>
                            <td style="border: 1px solid #000; padding: 5px;">{{ $p['cantidad'] }}</td>
                            <td style="border: 1px solid #000; padding: 5px;">${{ number_format($precio, 2) }}</td>
                            <td style="border: 1px solid #000; padding: 5px;">${{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <p><strong>Subtotal Herrajes:</strong> ${{ number_format($venta->subtotal_herrajes, 2) }}</p>
    @endif

    {{-- Vidrios --}}
    @if (collect($productos)->where('idc', 3)->count())
        <h5>Productos de Vidrio</h5>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
            <thead style="background-color: #001d4a; color: white;">
                <tr>
                    <th style="border: 1px solid #000; padding: 5px;">Producto</th>
                    <th style="border: 1px solid #000; padding: 5px;">Cantidad</th>
                    <th style="border: 1px solid #000; padding: 5px;">Precio Unitario</th>
                    <th style="border: 1px solid #000; padding: 5px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $p)
                    @if ($p['idc'] == 3)
                        @php
                            $precio = $p['precioh'] ?? 0;
                            $subtotal = $p['cantidad'] * $precio;
                            $nombre = $p['tonalidad'] . ' ' . $p['mm'] . 'mm';
                        @endphp
                        <tr>
                            <td style="border: 1px solid #000; padding: 5px;">{{ $nombre }}</td>
                            <td style="border: 1px solid #000; padding: 5px;">{{ $p['cantidad'] }}</td>
                            <td style="border: 1px solid #000; padding: 5px;">${{ number_format($precio, 2) }}</td>
                            <td style="border: 1px solid #000; padding: 5px;">${{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <p><strong>Subtotal Vidrio:</strong> ${{ number_format($venta->subtotal_vidrio, 2) }}</p>
    @endif

    {{-- Totales y descuento --}}
    <div class="totales">
        @if (isset($tipo_descuento))
            <p><strong>Total sin descuento:
                </strong>${{ number_format($venta->descuento_aplicado + $venta->total, 2) }}</p>
            <p><strong>Descuento aplicado: </strong>{{ 115 - (100 + $tipo_descuento->porcentaje) }}%</p>
            <p><strong>Monto descontado: </strong>${{ number_format($venta->descuento_aplicado, 2) }}</p>
        @else
            <p><strong>Descuento aplicado: </strong>No aplica</p>
        @endif

        <h3><strong>Total a pagar: </strong>${{ number_format($venta->total, 2) }}</h3>
    </div>

    <p style="margin-top: 30px;">Gracias por su preferencia</p>
</body>

</html>
