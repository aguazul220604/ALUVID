<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\NuevaVenta;

class ControladorLiquidar extends Controller
{
    public function liquidar()
    {
        return view('liquidar');
    }

    public function liquidar_procesar(Request $request)
    {
        $carrito = $request->input('carrito');
        $cliente = $request->input('cliente');

        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        // ----------------------------------------------------------
        // CALCULAR TOTAL ACUMULADO DEL CLIENTE EN EL MES ACTUAL
        // ----------------------------------------------------------
        $comprasDelMes = DB::table('ventas')
            ->where('contacto', $cliente['telefono'])
            ->whereBetween('fecha_solicitud', [$inicioMes, $finMes])
            ->sum('total');

        DB::beginTransaction();

        try {
            $subtotal_aluminio = 0;
            $subtotal_herrajes = 0;
            $subtotal_vidrio = 0;

            // ----------------------------------------------------------
            // PROCESAR PRODUCTOS DEL CARRITO
            // ----------------------------------------------------------
            foreach ($carrito as $producto) {
                $idc = intval($producto['idc']);
                $idProducto = $producto['id'];
                $cantidad = floatval($producto['cantidad']);

                if ($idc === 1) { // ALUMINIO
                    $stock = DB::table('stock_aluminio')->where('id_producto', $idProducto)->first();
                    if (!$stock || $stock->piezas < $cantidad) {
                        throw new \Exception("Stock insuficiente de aluminio para producto ID $idProducto.");
                    }
                    DB::table('stock_aluminio')->where('id_producto', $idProducto)->update([
                        'piezas' => $stock->piezas - $cantidad
                    ]);
                    $subtotal_aluminio += $producto['preciop'] * $cantidad;
                } elseif ($idc === 2) { // HERRAJES
                    $stock = DB::table('stock_herrajes')->where('id_producto', $idProducto)->first();
                    if (!$stock || $stock->cantidad < $cantidad) {
                        throw new \Exception("Stock insuficiente de herrajes para producto ID $idProducto.");
                    }
                    DB::table('stock_herrajes')->where('id_producto', $idProducto)->update([
                        'cantidad' => $stock->cantidad - $cantidad
                    ]);
                    $subtotal_herrajes += $producto['precio'] * $cantidad;
                } elseif ($idc === 3) { // VIDRIO
                    $stock = DB::table('stock_vidrio')->where('id_producto', $idProducto)->first();
                    if (!$stock || $stock->hojas < $cantidad) {
                        throw new \Exception("Stock insuficiente de vidrio para producto ID $idProducto.");
                    }
                    DB::table('stock_vidrio')->where('id_producto', $idProducto)->update([
                        'hojas' => $stock->hojas - $cantidad
                    ]);
                    $subtotal_vidrio += $producto['precioh'] * $cantidad;
                }
            }

            // ----------------------------------------------------------
            // CALCULAR TOTAL GENERAL
            // ----------------------------------------------------------
            $total = $subtotal_aluminio + $subtotal_herrajes + $subtotal_vidrio;

            // ----------------------------------------------------------
            // APLICAR DESCUENTO SEGÚN REGLAS DE NEGOCIO
            // ----------------------------------------------------------
            $porcentaje = 0;
            $descripcionDelDescuento = 'Sin descuento';
            $id_descuento = null;

            if ($comprasDelMes > 0 && $comprasDelMes <= 5000) {
                $porcentaje = 0;
                $descripcionDelDescuento = 'Compra baja (0%)';
                $id_descuento = 3;
            } elseif ($comprasDelMes > 5000 && $comprasDelMes <= 25000) {
                $porcentaje = 10;
                $descripcionDelDescuento = 'Compra media (10%)';
                $id_descuento = 2;
            } elseif ($comprasDelMes > 25000) {
                $porcentaje = 15;
                $descripcionDelDescuento = 'Compra alta (15%)';
                $id_descuento = 1;
            }

            // ----------------------------------------------------------
            // CALCULAR TOTAL CON DESCUENTO
            // ----------------------------------------------------------
            $totalConDescuento = $total * (1 - ($porcentaje / 100));
            $descuento = $total - $totalConDescuento;

            // ----------------------------------------------------------
            // GUARDAR LA VENTA
            // ----------------------------------------------------------
            $ventaId = DB::table('ventas')->insertGetId([
                'nombre_cliente'     => $cliente['nombre'],
                'apellido_cliente'   => $cliente['apellido'],
                'contacto'           => $cliente['telefono'],
                'subtotal_aluminio'  => $subtotal_aluminio,
                'subtotal_herrajes'  => $subtotal_herrajes,
                'subtotal_vidrio'    => $subtotal_vidrio,
                'total'              => $totalConDescuento,
                'descuento_aplicado' => $descuento,
                'id_descuento'       => $id_descuento,
                'fecha_solicitud'    => now(),
                'fecha_entrega'      => $cliente['fecha'],
                'hora_entrega'       => $cliente['hora'],
                'productos'          => json_encode($carrito)
            ]);

            // ----------------------------------------------------------
            // NOTIFICAR AL ADMINISTRADOR
            // ----------------------------------------------------------
            $venta = DB::table('ventas')->where('id', $ventaId)->first();
            $user = User::first();
            if ($user) {
                $user->notify(new NuevaVenta($venta));
            }

            DB::commit();

            return response()->json([
                'success'     => true,
                'message'     => 'Pedido procesado correctamente.',
                'venta_id'    => $ventaId,
                'porcentaje'  => $porcentaje,
                'descripcion' => $descripcionDelDescuento,
                'total_final' => round($totalConDescuento, 2),
                'acumulado_mes' => round($comprasDelMes + $totalConDescuento, 2)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }

    public function generarPDF($id)
    {
        $venta = DB::table('ventas')->find($id);

        if (!$venta) {
            abort(404);
        }

        $productos = json_decode($venta->productos, true);

        $tipo_descuento = null;
        if ($venta->id_descuento) {
            $tipo_descuento = DB::table('porcentaje_precios')->find($venta->id_descuento);
        }

        $pdf = PDF::loadView('pdf.venta', compact('venta', 'productos', 'tipo_descuento'));

        return $pdf->stream('pedido_' . $venta->id . '.pdf');
    }
}
