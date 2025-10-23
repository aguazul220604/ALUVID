<?php

namespace App\Http\Controllers;

use App\Models\stock_aluminio;
use App\Models\stock_herrajes;
use App\Models\stock_vidrio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use App\Models\ventas;

class VentasController extends Controller
{

    public function ventas()
    {
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();
        $user = Auth::user();

        $ventas = Ventas::whereBetween('fecha_solicitud', [$inicioMes, $finMes])->get();

        $stock_aluminio = DB::table('productos_aluminio')
            ->join('tipos_aluminio', 'productos_aluminio.id_tipo', '=', 'tipos_aluminio.id')
            ->join('series_aluminio', 'tipos_aluminio.id_serie', '=', 'series_aluminio.id')
            ->join('lineas', 'tipos_aluminio.id_linea', '=', 'lineas.id')
            ->join('stock_aluminio', 'stock_aluminio.id_producto', '=', 'productos_aluminio.id')
            ->leftJoin('precios_aluminio', 'precios_aluminio.id_producto', '=', 'productos_aluminio.id')
            ->select(
                'productos_aluminio.id as id',
                'productos_aluminio.codigo',
                'productos_aluminio.producto',
                'productos_aluminio.imagen',
                'lineas.id as id_linea',
                'lineas.descripcion as linea',
                'series_aluminio.id as id_serie',
                'series_aluminio.descripcion as serie',
                'stock_aluminio.piezas as stock_cantidad',
                'precios_aluminio.precio_venta_pieza as precio_venta',
            )
            ->where('stock_aluminio.piezas', '>', 0)
            ->get();

        $stock_vidrios = DB::table('productos_vidrio')
            ->join('vidrio_tonalidades', 'productos_vidrio.id_tonalidad', '=', 'vidrio_tonalidades.id')
            ->join('vidrio_mm', 'productos_vidrio.id_mm', '=', 'vidrio_mm.id')
            ->join('stock_vidrio', 'stock_vidrio.id_producto', '=', 'productos_vidrio.id')
            ->leftJoin('precios_vidrio', 'precios_vidrio.id_producto', '=', 'productos_vidrio.id')
            ->select(
                'productos_vidrio.id as id',
                'vidrio_tonalidades.id as id_tonalidad',
                'vidrio_tonalidades.descripcion as tonalidad',
                'vidrio_mm.id as id_mm',
                'vidrio_mm.mm as mm',
                'vidrio_tonalidades.imagen as imagen',
                'stock_vidrio.hojas as stock_cantidad',
                'precios_vidrio.precio_venta_hoja as precio_venta',
            )
            ->where('hojas', '>', 0)->get();

        $stock_herrajes = DB::table('productos_herrajes')
            ->join('tipos_herrajes', 'productos_herrajes.id_tipo', '=', 'tipos_herrajes.id')
            ->join('series_herrajes', 'tipos_herrajes.id_serie', '=', 'series_herrajes.id')
            ->join('lineas', 'tipos_herrajes.id_linea', '=', 'lineas.id')
            ->join('stock_herrajes', 'stock_herrajes.id_producto', '=', 'productos_herrajes.id')
            ->leftJoin('precios_herrajes', 'precios_herrajes.id_producto', '=', 'productos_herrajes.id')
            ->select(
                'productos_herrajes.id as id',
                'productos_herrajes.codigo',
                'productos_herrajes.producto',
                'productos_herrajes.imagen',
                'lineas.id as id_linea',
                'lineas.descripcion as linea',
                'series_herrajes.id as id_serie',
                'series_herrajes.descripcion as serie',
                'stock_herrajes.cantidad as stock_cantidad',
                'precios_herrajes.precio_venta as precio_venta',
            )
            ->where('cantidad', '>', 0)->get();

        return view('admin.ventas', compact('user', 'ventas', 'stock_aluminio', 'stock_vidrios', 'stock_herrajes'));
    }

    public function generar(Request $request)
    {
        $periodo_tiempo = $request->input('periodo');

        $hoy = Carbon::today();

        switch ($periodo_tiempo) {
            case 'diario':
                $ventas = DB::table('ventas')
                    ->whereDate('fecha_solicitud', $hoy)
                    ->get();
                break;

            case 'semanal':
                $inicioSemana = Carbon::now()->startOfWeek();
                $finSemana = Carbon::now()->endOfWeek();
                $ventas = DB::table('ventas')
                    ->whereBetween('fecha_solicitud', [$inicioSemana, $finSemana])
                    ->get();
                break;

            case 'mensual':
                $ventas = DB::table('ventas')
                    ->whereMonth('fecha_solicitud', $hoy->month)
                    ->whereYear('fecha_solicitud', $hoy->year)
                    ->get();
                break;

            default:
                $ventas = collect();
                break;
        }

        $datosReporte = [];
        $inversionTotal = 0;
        $ventaTotal = 0;
        $gananciaTotal = 0;

        foreach ($ventas as $venta) {
            $productos = json_decode($venta->productos, true);
            $detalleVenta = [
                'cliente' => $venta->nombre_cliente . ' ' . $venta->apellido_cliente,
                'id_venta' => $venta->id,
                'productos' => [
                    'aluminio' => [],
                    'herrajes' => [],
                    'vidrio' => [],
                ],
                'venta' => $venta->total,
                'porcentaje' => $venta->descuento_aplicado ?? 0,
                'inversion' => 0,
                'ganancia' => 0,
            ];

            foreach ($productos as $producto) {
                $precio_compra = 0;

                switch ($producto['idc']) {
                    case '1': // Aluminio 
                        $registro = DB::table('precios_aluminio')->where('id_producto', $producto['id'])->first();
                        $precio_compra = $registro->precio_compra_pieza ?? 0;
                        $detalleVenta['productos']['aluminio'][] = [
                            'nombre' => $producto['producto'] ?? '',
                            'cantidad' => $producto['cantidad'],
                            'precio_compra' => $precio_compra,
                            'subtotal' => $precio_compra * $producto['cantidad'],
                        ];
                        break;

                    case '2': // Herrajes
                        $registro = DB::table('precios_herrajes')->where('id_producto', $producto['id'])->first();
                        $precio_compra = $registro->precio_compra ?? 0;
                        $detalleVenta['productos']['herrajes'][] = [
                            'nombre' => $producto['producto'] ?? '',
                            'cantidad' => $producto['cantidad'],
                            'precio_compra' => $precio_compra,
                            'subtotal' => $precio_compra * $producto['cantidad'],
                        ];
                        break;

                    case '3': // Vidrio
                        $registro = DB::table('precios_vidrio')->where('id_producto', $producto['id'])->first();
                        $precio_compra = $registro->precio_compra_hoja ?? 0;
                        $detalleVenta['productos']['vidrio'][] = [
                            'nombre' => $producto['tonalidad'] . ' ' . $producto['mm'] . 'mm',
                            'cantidad' => $producto['cantidad'],
                            'precio_compra' => $precio_compra,
                            'subtotal' => $precio_compra * $producto['cantidad'],
                        ];
                        break;
                }

                $detalleVenta['inversion'] += $precio_compra * $producto['cantidad'];
            }

            $detalleVenta['ganancia'] = ($detalleVenta['venta'] + $detalleVenta['porcentaje']) - $detalleVenta['inversion'];

            // Acumular totales
            $inversionTotal += $detalleVenta['inversion'];
            $ventaTotal += ($detalleVenta['venta'] + $detalleVenta['porcentaje']);
            $gananciaTotal += $detalleVenta['ganancia'];

            $datosReporte[] = $detalleVenta;
        }


        $pdf = PDF::loadView('pdf.reporte_ventas', [
            'datosReporte' => $datosReporte,
            'inversionTotal' => $inversionTotal,
            'ventaTotal' => $ventaTotal,
            'gananciaTotal' => $gananciaTotal,
            'periodo_tiempo' => $periodo_tiempo,
        ]);
        return $pdf->stream('reporte_ventas' . '.pdf');
    }

    public function estadisticas(Request $request)
    {
        $periodo_tiempo = $request->query('periodo');
        $hoy = Carbon::today();

        switch ($periodo_tiempo) {
            case 'diario':
                $ventas = DB::table('ventas')
                    ->whereDate('fecha_solicitud', $hoy)
                    ->get();
                break;

            case 'semanal':
                $inicioSemana = Carbon::now()->startOfWeek();
                $finSemana = Carbon::now()->endOfWeek();
                $ventas = DB::table('ventas')
                    ->whereBetween('fecha_solicitud', [$inicioSemana, $finSemana])
                    ->get();
                break;

            case 'mensual':
                $ventas = DB::table('ventas')
                    ->whereMonth('fecha_solicitud', $hoy->month)
                    ->whereYear('fecha_solicitud', $hoy->year)
                    ->get();
                break;

            default:
                $ventas = collect();
                break;
        }

        $inversionTotal = 0;
        $ventaTotal = 0;
        $gananciaTotal = 0;

        foreach ($ventas as $venta) {
            $productos = json_decode($venta->productos, true);
            $ventaTotalBruta = $venta->total + ($venta->descuento_aplicado ?? 0);
            $inversionVenta = 0;

            foreach ($productos as $producto) {
                $precio_compra = 0;

                switch ($producto['idc']) {
                    case '1': // Aluminio
                        $registro = DB::table('precios_aluminio')->where('id_producto', $producto['id'])->first();
                        $precio_compra = $registro->precio_compra_pieza ?? 0;
                        break;

                    case '2': // Herrajes
                        $registro = DB::table('precios_herrajes')->where('id_producto', $producto['id'])->first();
                        $precio_compra = $registro->precio_compra ?? 0;
                        break;

                    case '3': // Vidrio
                        $registro = DB::table('precios_vidrio')->where('id_producto', $producto['id'])->first();
                        $precio_compra = $registro->precio_compra_hoja ?? 0;
                        break;
                }

                $inversionVenta += $precio_compra * $producto['cantidad'];
            }

            $ganancia = $ventaTotalBruta - $inversionVenta;

            $inversionTotal += $inversionVenta;
            $ventaTotal += $ventaTotalBruta;
            $gananciaTotal += $ganancia;
        }

        return response()->json([
            'inversionTotal' => $inversionTotal,
            'ventaTotal' => $ventaTotal,
            'gananciaTotal' => $gananciaTotal,
        ]);
    }

    public function ventas_update(Request $request, $id)
    {
        $productosInput = $request->input('productos', []);
        $productos_actualizados = [];
        $subtotal_aluminio = 0;
        $subtotal_herrajes = 0;
        $subtotal_vidrio = 0;

        foreach ($productosInput as $categoria => $items) {
            foreach ($items as $item) {
                $idProducto = $item['id'] ?? null;
                $cantidad = intval($item['cantidad'] ?? 0);
                if (!$idProducto) continue;

                switch ($categoria) {
                    case 1: // Aluminio
                        $datosProducto = DB::table('productos_aluminio as pa')
                            ->leftJoin('precios_aluminio as ppa', 'pa.id', '=', 'ppa.id_producto')
                            ->leftJoin('stock_aluminio as sa', 'pa.id', '=', 'sa.id_producto')
                            ->where('pa.id', $idProducto)
                            ->select(
                                'pa.id',
                                'pa.codigo',
                                'pa.producto',
                                'pa.imagen',
                                'ppa.precio_venta_pieza as precio',
                                'sa.piezas as stock'
                            )
                            ->first();

                        // Validar cantidad <= stock
                        $cantidad = min($cantidad, $datosProducto->stock ?? 0);

                        DB::table('stock_aluminio')
                            ->where('id_producto', $idProducto)
                            ->update(['piezas' => DB::raw("piezas + {$cantidad}")]);

                        $precioFinal = $datosProducto->precio ?? 0;
                        $subtotal_aluminio += $precioFinal * $cantidad;

                        $productos_actualizados[] = [
                            'idc' => 1,
                            'id' => $idProducto,
                            'preciop' => $precioFinal,
                            'cantidad' => $cantidad,
                            'codigo' => $datosProducto->codigo ?? null,
                            'producto' => $datosProducto->producto ?? null,
                            'imagen' => $datosProducto->imagen ?? null,
                            'stock' => $datosProducto->stock ?? null,
                        ];
                        break;

                    case 2: // Herrajes
                        $datosProducto = DB::table('productos_herrajes as ph')
                            ->leftJoin('precios_herrajes as pph', 'ph.id', '=', 'pph.id_producto')
                            ->leftJoin('stock_herrajes as sh', 'ph.id', '=', 'sh.id_producto')
                            ->where('ph.id', $idProducto)
                            ->select(
                                'ph.id',
                                'ph.codigo',
                                'ph.producto',
                                'ph.imagen',
                                'pph.precio_venta as precio',
                                'sh.cantidad as stock'
                            )
                            ->first();

                        $cantidad = min($cantidad, $datosProducto->stock ?? 0);

                        DB::table('stock_herrajes')
                            ->where('id_producto', $idProducto)
                            ->update(['cantidad' => DB::raw("cantidad + {$cantidad}")]);

                        $precioFinal = $datosProducto->precio ?? 0;
                        $subtotal_herrajes += $precioFinal * $cantidad;

                        $productos_actualizados[] = [
                            'idc' => 2,
                            'id' => $idProducto,
                            'precio' => $precioFinal,
                            'cantidad' => $cantidad,
                            'codigo' => $datosProducto->codigo ?? null,
                            'producto' => $datosProducto->producto ?? null,
                            'imagen' => $datosProducto->imagen ?? null,
                            'stock' => $datosProducto->stock ?? null,
                        ];
                        break;

                    case 3: // Vidrio
                        $datosProducto = DB::table('productos_vidrio as pv')
                            ->leftJoin('vidrio_tonalidades as vt', 'pv.id_tonalidad', '=', 'vt.id')
                            ->leftJoin('vidrio_mm as vm', 'pv.id_mm', '=', 'vm.id')
                            ->leftJoin('precios_vidrio as pvh', 'pv.id', '=', 'pvh.id_producto')
                            ->leftJoin('stock_vidrio as vs', 'pv.id', '=', 'vs.id_producto')
                            ->where('pv.id', $idProducto)
                            ->select(
                                'pv.id',
                                'pvh.precio_venta_hoja as precioh',
                                'vs.hojas as stock',
                                'vt.descripcion',
                                'vt.imagen',
                                'vm.mm'
                            )
                            ->first();

                        $cantidad = min($cantidad, $datosProducto->stock ?? 0);

                        DB::table('stock_vidrio')
                            ->where('id_producto', $idProducto)
                            ->update(['hojas' => DB::raw("hojas + {$cantidad}")]);

                        $precioFinal = $datosProducto->precioh ?? 0;
                        $subtotal_vidrio += $precioFinal * $cantidad;

                        $productos_actualizados[] = [
                            'idc' => 3,
                            'id' => $idProducto,
                            'cantidad' => $cantidad,
                            'tonalidad' => $datosProducto->descripcion ?? null,
                            'mm' => $datosProducto->mm ?? null,
                            'imagen' => $datosProducto->imagen ?? null,
                            'precioh' => $precioFinal,
                            'stock' => $datosProducto->stock ?? null,
                        ];
                        break;
                }
            }
        }

        // Calcular total como suma de subtotales
        $nuevoTotal = $subtotal_aluminio + $subtotal_herrajes + $subtotal_vidrio;

        // Obtener el total anterior
        $ventaAnterior = DB::table('ventas')->where('id', $id)->select('total')->first();
        $totalAnterior = $ventaAnterior->total ?? 0;

        // Calcular diferencia
        $diferencia = $nuevoTotal - $totalAnterior;

        // Guardar en la tabla ventas
        DB::table('ventas')->where('id', $id)->update([
            'productos' => json_encode($productos_actualizados),
            'subtotal_aluminio' => $subtotal_aluminio,
            'subtotal_herrajes' => $subtotal_herrajes,
            'subtotal_vidrio' => $subtotal_vidrio,
            'total' => $nuevoTotal,
            'id_descuento' => 3,
            'diferencia' => $diferencia,
        ]);

        return back()->with('message', 'update');
    }



    public function venta_delete($id)
    {
        $venta = ventas::findOrFail($id);

        // Eliminar el registro de la base de datos
        $venta->delete();

        return back()->with('message', 'deleted');
    }

    public function reporte_venta_update($id)
    {
        $venta = DB::table('ventas')->where('id', $id)->first();
        $productos_json = json_decode($venta->productos, true) ?? [];

        $productos = [];

        foreach ($productos_json as $p) {
            $tipo = '';
            $nombre = '';
            $precio = 0;

            switch ($p['idc']) {
                case 1: // Aluminio
                    $tipo = 'Aluminio';
                    $nombre = $p['producto'] ?? '';
                    $precio = floatval($p['preciop'] ?? 0);
                    break;

                case 2: // Herrajes
                    $tipo = 'Herraje';
                    $nombre = $p['producto'] ?? '';
                    $precio = floatval($p['precio'] ?? 0);
                    break;

                case 3: // Vidrio
                    $tipo = 'Vidrio';
                    $nombre = ($p['tonalidad'] ?? '') . ' ' . ($p['mm'] ?? '') . 'mm';
                    $precio = floatval($p['precioh'] ?? 0);
                    break;
            }

            $cantidad = intval($p['cantidad'] ?? 0);
            $subtotal = $precio * $cantidad;

            $productos[] = [
                'tipo' => $tipo,
                'nombre' => $nombre,
                'cantidad' => $cantidad,
                'precio' => $precio,
                'subtotal' => $subtotal,
            ];
        }

        // Diferencia absoluta para mostrar en la vista
        $diferencia = isset($venta->diferencia) ? abs($venta->diferencia) : 0;

        $pdf = Pdf::loadView('pdf.venta_update', [
            'venta' => $venta,
            'productos' => $productos,
            'diferencia' => $diferencia
        ]);

        return $pdf->stream("venta_update_{$id}.pdf");
    }
}
