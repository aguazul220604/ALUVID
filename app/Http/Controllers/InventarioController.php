<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InventarioController extends Controller
{
    public function inventario_aluminio()
    {
        $productos_aluminio = DB::table('productos_aluminio')
            ->join('tipos_aluminio', 'productos_aluminio.id_tipo', '=', 'tipos_aluminio.id')
            ->join('series_aluminio', 'tipos_aluminio.id_serie', '=', 'series_aluminio.id')
            ->join('lineas', 'tipos_aluminio.id_linea', '=', 'lineas.id')
            ->leftJoin('stock_aluminio', 'stock_aluminio.id_producto', '=', 'productos_aluminio.id')
            ->select(
                'productos_aluminio.codigo',
                'productos_aluminio.producto',
                'lineas.descripcion as linea',
                'series_aluminio.descripcion as serie',
                'stock_aluminio.piezas as piezas',
                'stock_aluminio.cantidad_metros as cantidad_metros',
            )->orderBy('series_aluminio.id', 'asc')
            ->get();
        $fecha_actual = Carbon::now();
        $pdf = PDF::loadView('pdf.inventarios.inventario_aluminio', compact('productos_aluminio', 'fecha_actual'));
        return $pdf->stream('inventario_aluminio_' . $fecha_actual . '.pdf');
    }

    public function inventario_vidrio()
    {
        $productos_vidrio = DB::table('productos_vidrio')
            ->join('vidrio_tonalidades', 'productos_vidrio.id_tonalidad', '=', 'vidrio_tonalidades.id')
            ->join('vidrio_mm', 'productos_vidrio.id_mm', '=', 'vidrio_mm.id')
            ->leftJoin('stock_vidrio', 'stock_vidrio.id_producto', '=', 'productos_vidrio.id')
            ->select(
                'vidrio_tonalidades.descripcion as tonalidad',
                'vidrio_mm.mm as mm',
                'stock_vidrio.hojas as hojas',
                'stock_vidrio.cantidad_metros_2 as cantidad_metros_2'
            )->orderBy('vidrio_tonalidades.descripcion', 'asc')
            ->get();
        $fecha_actual = Carbon::now();
        $pdf = PDF::loadView('pdf.inventarios.inventario_vidrio', compact('productos_vidrio', 'fecha_actual'));
        return $pdf->stream('inventario_vidrio_' . $fecha_actual . '.pdf');
    }

    public function inventario_herrajes()
    {
        $productos_herrajes = DB::table('productos_herrajes')
            ->join('tipos_herrajes', 'productos_herrajes.id_tipo', '=', 'tipos_herrajes.id')
            ->join('series_herrajes', 'tipos_herrajes.id_serie', '=', 'series_herrajes.id')
            ->join('lineas', 'tipos_herrajes.id_linea', '=', 'lineas.id')
            ->leftJoin('stock_herrajes', 'stock_herrajes.id_producto', '=', 'productos_herrajes.id')
            ->select(
                'productos_herrajes.codigo',
                'productos_herrajes.producto',
                'lineas.descripcion as linea',
                'series_herrajes.descripcion as serie',
                'stock_herrajes.cantidad as stock_cantidad',
            )->orderBy('series_herrajes.id', 'asc')
            ->get();
        $fecha_actual = Carbon::now();
        $pdf = PDF::loadView('pdf.inventarios.inventario_herrajes', compact('productos_herrajes', 'fecha_actual'));
        return $pdf->stream('inventario_herrajes_' . $fecha_actual . '.pdf');
    }
}
