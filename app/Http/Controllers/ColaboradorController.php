<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\lineas;
use App\Models\vidrio_tonalidades;
use App\Models\vidrio_mm;
use App\Models\ventas;

use Carbon\Carbon;

class ColaboradorController extends Controller
{
    public function inicio()
    {
        $user = Auth::user();
        return view('colab.inicio', compact('user'));
    }

    public function consulta_vidrio()
    {
        $user = Auth::user();
        $productos_vidrio = DB::table('productos_vidrio')
            ->join('vidrio_tonalidades', 'productos_vidrio.id_tonalidad', '=', 'vidrio_tonalidades.id')
            ->join('vidrio_mm', 'productos_vidrio.id_mm', '=', 'vidrio_mm.id')
            ->leftJoin('stock_vidrio', 'stock_vidrio.id_producto', '=', 'productos_vidrio.id')
            ->select(
                'productos_vidrio.id as id',
                'vidrio_tonalidades.id as id_tonalidad',
                'vidrio_tonalidades.descripcion as tonalidad',
                'vidrio_mm.id as id_mm',
                'vidrio_mm.mm as mm',
                'vidrio_tonalidades.imagen as imagen',
                'stock_vidrio.hojas as hojas',
                'stock_vidrio.cantidad_metros_2 as cantidad_metros_2'
            )
            ->get();

        $vidrio_tonalidades = vidrio_tonalidades::all();

        $vidrio_mm = vidrio_mm::all();

        $tipos_tonalidades = DB::table('productos_vidrio')
            ->join('vidrio_tonalidades', 'productos_vidrio.id_tonalidad', '=', 'vidrio_tonalidades.id')
            ->join('vidrio_mm', 'productos_vidrio.id_mm', '=', 'vidrio_mm.id')
            ->select(
                'productos_vidrio.id as id_vidrio',
                'vidrio_tonalidades.id as id_tonalidad',
                'vidrio_tonalidades.descripcion as tonalidad',
                'vidrio_mm.id as id_mm',
                'vidrio_mm.mm as mm'
            )
            ->get();

        return view('colab.vidrios', compact('user', 'productos_vidrio', 'vidrio_tonalidades', 'vidrio_mm', 'tipos_tonalidades'));
    }

    public function consulta_aluminio()
    {
        $user = Auth::user();

        $productos_aluminio = DB::table('productos_aluminio')
            ->join('tipos_aluminio', 'productos_aluminio.id_tipo', '=', 'tipos_aluminio.id')
            ->join('series_aluminio', 'tipos_aluminio.id_serie', '=', 'series_aluminio.id')
            ->join('lineas', 'tipos_aluminio.id_linea', '=', 'lineas.id')
            ->leftJoin('stock_aluminio', 'stock_aluminio.id_producto', '=', 'productos_aluminio.id')
            ->select(
                'productos_aluminio.id',
                'productos_aluminio.codigo',
                'productos_aluminio.producto',
                'productos_aluminio.imagen',
                'lineas.id as id_linea',
                'lineas.descripcion as linea',
                'series_aluminio.id as id_serie',
                'series_aluminio.descripcion as serie',
                'stock_aluminio.piezas as stock_cantidad',
                'stock_aluminio.cantidad_metros as metros',
            )
            ->get();

        $lineas_aluminio = lineas::all();

        $tipos_aluminio = DB::table('tipos_aluminio')
            ->join('series_aluminio', 'tipos_aluminio.id_serie', '=', 'series_aluminio.id')
            ->join('lineas', 'tipos_aluminio.id_linea', '=', 'lineas.id')
            ->select(
                'tipos_aluminio.id as id_tipo',
                'lineas.id as id_linea',
                'lineas.descripcion as linea',
                'series_aluminio.id as id_serie',
                'series_aluminio.descripcion as serie'
            )
            ->get();

        return view('colab.aluminio', compact('productos_aluminio', 'lineas_aluminio', 'tipos_aluminio', 'user'));
    }

    public function consulta_herrajes()
    {
        $user = Auth::user();

        $productos_herrajes = DB::table('productos_herrajes')
            ->join('tipos_herrajes', 'productos_herrajes.id_tipo', '=', 'tipos_herrajes.id')
            ->join('series_herrajes', 'tipos_herrajes.id_serie', '=', 'series_herrajes.id')
            ->join('lineas', 'tipos_herrajes.id_linea', '=', 'lineas.id')
            ->leftJoin('stock_herrajes', 'stock_herrajes.id_producto', '=', 'productos_herrajes.id')
            ->select(
                'productos_herrajes.id',
                'productos_herrajes.codigo',
                'productos_herrajes.producto',
                'productos_herrajes.imagen',
                'lineas.id as id_linea',
                'lineas.descripcion as linea',
                'series_herrajes.id as id_serie',
                'series_herrajes.descripcion as serie',
                'stock_herrajes.cantidad as stock_cantidad',
            )
            ->get();

        $lineas_herrajes = lineas::all();

        $tipos_herrajes = DB::table('tipos_herrajes')
            ->join('series_herrajes', 'tipos_herrajes.id_serie', '=', 'series_herrajes.id')
            ->join('lineas', 'tipos_herrajes.id_linea', '=', 'lineas.id')
            ->select(
                'tipos_herrajes.id as id_tipo',
                'lineas.id as id_linea',
                'lineas.descripcion as linea',
                'series_herrajes.id as id_serie',
                'series_herrajes.descripcion as serie'
            )
            ->get();

        return view('colab.herrajes', compact('productos_herrajes', 'lineas_herrajes', 'tipos_herrajes', 'user'));
    }

    public function consulta_ventas()
    {
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();
        $user = Auth::user();

        $ventas = Ventas::whereBetween('fecha_solicitud', [$inicioMes, $finMes])->get();
        return view('colab.ventas', compact('user', 'ventas'));
    }
}
