<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas - {{ ucfirst($periodo_tiempo) }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        h2,
        h3 {
            margin-bottom: 0;
        }

        .resumen {
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <h2>Reporte de Ventas - {{ ucfirst($periodo_tiempo) }}</h2>
    <p>Fecha de generación: {{ now()->format('d/m/Y H:i') }}</p>

    @foreach ($datosReporte as $venta)
        <h3>Venta #{{ $venta['id_venta'] }} - Cliente: {{ $venta['cliente'] }}</h3>

        @foreach (['aluminio', 'herrajes', 'vidrio'] as $categoria)
            @if (count($venta['productos'][$categoria]) > 0)
                <h4>{{ ucfirst($categoria) }}</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Compra</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($venta['productos'][$categoria] as $p)
                            <tr>
                                <td>{{ $p['nombre'] }}</td>
                                <td>{{ $p['cantidad'] }}</td>
                                <td>${{ number_format($p['precio_compra'], 2) }}</td>
                                <td>${{ number_format($p['subtotal'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach

        <p><strong>Total Venta:</strong> ${{ number_format($venta['venta'] + $venta['porcentaje'], 2) }}</p>
        <p><strong>Inversión:</strong> ${{ number_format($venta['inversion'], 2) }}</p>
        <p><strong>Ganancia:</strong> ${{ number_format($venta['ganancia'], 2) }}</p>
        <hr>
    @endforeach

    <div class="resumen">
        <h3>Resumen del período</h3>
        <p><strong>Venta Total:</strong> ${{ number_format($ventaTotal, 2) }}</p>
        <p><strong>Inversión Total:</strong> ${{ number_format($inversionTotal, 2) }}</p>
        <p><strong>Ganancia Total:</strong> ${{ number_format($gananciaTotal, 2) }}</p>
    </div>

</body>

</html>
