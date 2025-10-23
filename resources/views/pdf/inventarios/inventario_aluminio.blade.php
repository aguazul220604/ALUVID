<!DOCTYPE html>
<html lang="en">

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
            <h2>Inventario de aluminios</h2>
        </div>
        <div class="datos-negocio">
            <p>Lib. a Cardonal, San Nicolás</p>
            <p>42302 Ixmiquilpan, Hgo.</p>
            <p>Email: aluvidixmiquilpan@gmail.com</p>
            <p>Tel: 7712003391</p>
        </div>
    </div>

    <p>Fecha: {{ $fecha_actual }}</p>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
        <thead style="background-color: #001d4a; color: white;">
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Línea</th>
                <th>Serie</th>
                <th>Piezas disponibles</th>
                <th>Cantidad de metros equivalente</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos_aluminio as $producto_aluminio)
                <tr>
                    <td>{{ $producto_aluminio->codigo }}</td>
                    <td>{{ $producto_aluminio->producto }}</td>
                    <td>{{ $producto_aluminio->linea }}</td>
                    <td>{{ $producto_aluminio->serie }}</td>
                    <td>{{ $producto_aluminio->piezas }}</td>
                    <td>{{ $producto_aluminio->cantidad_metros }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
