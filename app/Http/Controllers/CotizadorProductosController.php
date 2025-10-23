<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CotizadorProductosController extends Controller
{
    public function generarCotizacionPDF(Request $request)
    {
        $carrito = $request->input('carrito');
        $cliente = $request->input('cliente');

        $subtotal_aluminio = 0;
        $subtotal_herrajes = 0;
        $subtotal_vidrio = 0;

        foreach ($carrito as &$producto) {
            $idc = intval($producto['idc']);
            $cantidad = floatval($producto['cantidad']);

            if ($idc === 1) {
                $precio = floatval($producto['preciop'] ?? 0);
                $producto['subtotal'] = $precio * $cantidad;
                $subtotal_aluminio += $producto['subtotal'];
            } elseif ($idc === 2) {
                $precio = floatval($producto['precio'] ?? 0);
                $producto['subtotal'] = $precio * $cantidad;
                $subtotal_herrajes += $producto['subtotal'];
            } elseif ($idc === 3) {
                $precio = floatval($producto['precioh'] ?? 0);
                $producto['subtotal'] = $precio * $cantidad;
                $subtotal_vidrio += $producto['subtotal'];
            }
        }

        $total = $subtotal_aluminio + $subtotal_herrajes + $subtotal_vidrio;

        // Obtener compras del mes actual por contacto
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();

        $comprasDelMes = DB::table('ventas')
            ->where('contacto', $cliente['telefono_cotizacion'])
            ->whereBetween('fecha_solicitud', [$inicioMes, $finMes])
            ->sum('total');

        // Buscar descuento aplicable
        $tipo_descuento = DB::table('porcentaje_precios')
            ->where('monto', '<=', $comprasDelMes)
            ->orderByDesc('monto')
            ->first();

        $porcentaje = 0;
        $descripcionDelDescuento = 'Sin descuento';

        if ($tipo_descuento) {
            $porcentaje = $tipo_descuento->porcentaje;
            $descripcionDelDescuento = $tipo_descuento->descripcion;
        }

        // Aplicar descuento igual que en el controlador de liquidar
        $totalConDescuento = (($total / 115) * (100 + $porcentaje));
        $descuento = $total - $totalConDescuento;

        $venta = (object)[
            'nombre_cliente'      => $cliente['nombre_cotizacion'],
            'apellido_cliente'    => $cliente['apellido_cotizacion'],
            'contacto'            => $cliente['telefono_cotizacion'],
            'subtotal_aluminio'   => $subtotal_aluminio,
            'subtotal_herrajes'   => $subtotal_herrajes,
            'subtotal_vidrio'     => $subtotal_vidrio,
            'total_sin_descuento' => $total,
            'total'               => $totalConDescuento,
            'descuento_aplicado'  => $descuento,
            'fecha_cotizacion'    => now(),
        ];

        $productos = $carrito;

        $pdf = PDF::loadView('pdf.cotizacion', compact('venta', 'productos', 'tipo_descuento', 'porcentaje'));

        return $pdf->stream('cotizacion.pdf');
    }
}
