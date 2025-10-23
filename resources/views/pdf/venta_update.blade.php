<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Venta #{{ $venta->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .logo {
            width: 120px;
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .datos-negocio {
            font-size: 10px;
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
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

    <h4>Resumen de Pedido</h4>
    <ul style="padding-left: 20px; margin: 0 0 10px 0; line-height: 1.2;">
        <li><strong>Cliente:</strong> {{ $venta->nombre_cliente }} {{ $venta->apellido_cliente }}</li>
        <li><strong>Teléfono:</strong> {{ $venta->contacto }}</li>
        <li><strong>Fecha de actualización:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</li>
        <li><strong>Folio:</strong> {{ $venta->id }}</li>
    </ul>

    @if ($diferencia > 0)
        <div style="text-align: center; margin: 20px 0;">
            <h2 style="color: green;">Ajuste de venta: ${{ number_format($diferencia, 2) }}</h2>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Producto</th>
                <th class="text-right">Cantidad</th>
                <th class="text-right">Precio</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($productos as $prod)
                <tr>
                    <td>{{ $prod['tipo'] }}</td>
                    <td>{{ $prod['nombre'] }}</td>
                    <td class="text-right">{{ $prod['cantidad'] }}</td>
                    <td class="text-right">${{ number_format($prod['precio'], 2) }}</td>
                    <td class="text-right">${{ number_format($prod['subtotal'], 2) }}</td>
                </tr>
                @php $total += $prod['subtotal']; @endphp
            @endforeach
            <tr>
                <td colspan="4" class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>${{ number_format($total, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top: 20px;">Gracias por su preferencia</p>

</body>

</html>
