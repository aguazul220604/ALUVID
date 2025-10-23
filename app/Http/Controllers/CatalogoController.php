<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\lineas;
use App\Models\vidrio_tonalidades;
use App\Models\vidrio_mm;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{

    ////////////////////////////////////////////////// ALUMINIOS

    public function catalogo_aluminios()
    {
        $productos_aluminio = DB::table('productos_aluminio')
            ->join('tipos_aluminio', 'productos_aluminio.id_tipo', '=', 'tipos_aluminio.id')
            ->join('series_aluminio', 'tipos_aluminio.id_serie', '=', 'series_aluminio.id')
            ->join('lineas', 'tipos_aluminio.id_linea', '=', 'lineas.id')
            ->join('precios_aluminio', 'productos_aluminio.id', '=', 'precios_aluminio.id_producto')
            ->leftJoin('stock_aluminio', 'stock_aluminio.id_producto', '=', 'productos_aluminio.id')
            ->select(
                'productos_aluminio.id',
                'productos_aluminio.codigo',
                'productos_aluminio.producto',
                'productos_aluminio.imagen',
                'productos_aluminio.id_categoria_producto as idc',
                'precios_aluminio.precio_venta_pieza as precio_pieza',
                'lineas.id as id_linea',
                'lineas.descripcion as linea',
                'series_aluminio.id as id_serie',
                'series_aluminio.descripcion as serie',
                'stock_aluminio.piezas as stock_cantidad',
            )
            ->paginate(6);


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

        return view('catalogo_aluminios', compact('productos_aluminio', 'lineas_aluminio', 'tipos_aluminio'));
    }

    public function ficha_tecnica_aluminios($id)
    {
        $producto_aluminio = DB::table('productos_aluminio')
            ->join('tipos_aluminio', 'productos_aluminio.id_tipo', '=', 'tipos_aluminio.id')
            ->join('series_aluminio', 'tipos_aluminio.id_serie', '=', 'series_aluminio.id')
            ->join('lineas', 'tipos_aluminio.id_linea', '=', 'lineas.id')
            ->join('precios_aluminio', 'productos_aluminio.id', '=', 'precios_aluminio.id_producto')
            ->leftJoin('stock_aluminio', 'stock_aluminio.id_producto', '=', 'productos_aluminio.id')
            ->select(
                'productos_aluminio.id',
                'productos_aluminio.codigo',
                'productos_aluminio.producto',
                'productos_aluminio.imagen',
                'productos_aluminio.id_categoria_producto as idc',
                'precios_aluminio.precio_venta_pieza as precio_pieza',
                'lineas.id as id_linea',
                'lineas.descripcion as linea',
                'series_aluminio.id as id_serie',
                'series_aluminio.descripcion as serie',
                'stock_aluminio.piezas as stock_cantidad',
            )
            ->where('productos_aluminio.id', '=', $id)
            ->get();

        return view('ficha_tecnica_aluminios', compact('producto_aluminio'));
    }

    public function filtrarProductosAluminio(Request $request)
    {
        $query = DB::table('productos_aluminio')
            ->join('tipos_aluminio', 'productos_aluminio.id_tipo', '=', 'tipos_aluminio.id')
            ->join('series_aluminio', 'tipos_aluminio.id_serie', '=', 'series_aluminio.id')
            ->join('lineas', 'tipos_aluminio.id_linea', '=', 'lineas.id')
            ->join('precios_aluminio', 'productos_aluminio.id', '=', 'precios_aluminio.id_producto')
            ->leftJoin('stock_aluminio', 'stock_aluminio.id_producto', '=', 'productos_aluminio.id')
            ->select(
                'productos_aluminio.id',
                'productos_aluminio.codigo',
                'productos_aluminio.producto',
                'precios_aluminio.precio_venta_pieza as precio_pieza',
                'productos_aluminio.imagen',
                'productos_aluminio.id_categoria_producto as idc',
                'stock_aluminio.piezas as stock_cantidad'
            );

        // Filtro por línea
        if ($request->has('linea')) {
            $query->where('lineas.id', $request->linea);
        }

        // Filtro por serie
        if ($request->has('serie')) {
            $query->where('series_aluminio.id', $request->serie);
        }

        // Filtro por búsqueda
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('productos_aluminio.codigo', 'like', '%' . $request->search . '%')
                    ->orWhere('productos_aluminio.producto', 'like', '%' . $request->search . '%');
            });
        }

        // Paginación
        $productos_aluminio = $query->paginate(6);

        return response()->json([
            'data' => $productos_aluminio->items(),
            'links' => [
                'current_page' => $productos_aluminio->currentPage(),
                'last_page' => $productos_aluminio->lastPage(),
                'next_page_url' => $productos_aluminio->nextPageUrl(),
                'prev_page_url' => $productos_aluminio->previousPageUrl(),
            ]
        ]);
    }

    ////////////////////////////////////////////////// HERRAJES

    public function catalogo_herrajes()
    {
        $productos_herrajes = DB::table('productos_herrajes')
            ->join('tipos_herrajes', 'productos_herrajes.id_tipo', '=', 'tipos_herrajes.id')
            ->join('series_herrajes', 'tipos_herrajes.id_serie', '=', 'series_herrajes.id')
            ->join('lineas', 'tipos_herrajes.id_linea', '=', 'lineas.id')
            ->join('precios_herrajes', 'productos_herrajes.id', '=', 'precios_herrajes.id_producto')
            ->leftJoin('stock_herrajes', 'stock_herrajes.id_producto', '=', 'productos_herrajes.id')
            ->select(
                'productos_herrajes.id',
                'productos_herrajes.codigo',
                'productos_herrajes.producto',
                'productos_herrajes.imagen',
                'productos_herrajes.id_categoria_producto as idc',
                'precios_herrajes.precio_venta as precio',
                'lineas.id as id_linea',
                'lineas.descripcion as linea',
                'series_herrajes.id as id_serie',
                'series_herrajes.descripcion as serie',
                'stock_herrajes.cantidad as stock_cantidad'
            )
            ->paginate(6);


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

        return view('catalogo_herrajes', compact('productos_herrajes', 'lineas_herrajes', 'tipos_herrajes'));
    }

    public function ficha_tecnica_herrajes($id)
    {
        $producto_herrajes = DB::table('productos_herrajes')
            ->join('tipos_herrajes', 'productos_herrajes.id_tipo', '=', 'tipos_herrajes.id')
            ->join('series_herrajes', 'tipos_herrajes.id_serie', '=', 'series_herrajes.id')
            ->join('lineas', 'tipos_herrajes.id_linea', '=', 'lineas.id')
            ->join('precios_herrajes', 'productos_herrajes.id', '=', 'precios_herrajes.id_producto')
            ->leftJoin('stock_herrajes', 'stock_herrajes.id_producto', '=', 'productos_herrajes.id')
            ->select(
                'productos_herrajes.id',
                'productos_herrajes.codigo',
                'productos_herrajes.producto',
                'productos_herrajes.imagen',
                'productos_herrajes.id_categoria_producto as idc',
                'precios_herrajes.precio_venta as precio',
                'lineas.id as id_linea',
                'lineas.descripcion as linea',
                'series_herrajes.id as id_serie',
                'series_herrajes.descripcion as serie',
                'stock_herrajes.cantidad as stock_cantidad'
            )
            ->where('productos_herrajes.id', '=', $id)
            ->get();

        return view('ficha_tecnica_herrajes', compact('producto_herrajes'));
    }

    public function filtrarProductosHerrajes(Request $request)
    {
        $query = DB::table('productos_herrajes')
            ->join('tipos_herrajes', 'productos_herrajes.id_tipo', '=', 'tipos_herrajes.id')
            ->join('series_herrajes', 'tipos_herrajes.id_serie', '=', 'series_herrajes.id')
            ->join('lineas', 'tipos_herrajes.id_linea', '=', 'lineas.id')
            ->join('precios_herrajes', 'productos_herrajes.id', '=', 'precios_herrajes.id_producto')
            ->leftJoin('stock_herrajes', 'stock_herrajes.id_producto', '=', 'productos_herrajes.id')
            ->select(
                'productos_herrajes.id',
                'productos_herrajes.codigo',
                'productos_herrajes.producto',
                'precios_herrajes.precio_venta as precio',
                'productos_herrajes.imagen',
                'productos_herrajes.id_categoria_producto as idc',
                'stock_herrajes.cantidad as stock_cantidad'
            );

        // Filtro por línea
        if ($request->has('linea')) {
            $query->where('lineas.id', $request->linea);
        }

        // Filtro por serie
        if ($request->has('serie')) {
            $query->where('series_herrajes.id', $request->serie);
        }

        // Filtro por búsqueda
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('productos_herrajes.codigo', 'like', '%' . $request->search . '%')
                    ->orWhere('productos_herrajes.producto', 'like', '%' . $request->search . '%');
            });
        }

        // Paginación
        $productos_herrajes = $query->paginate(6);

        return response()->json([
            'data' => $productos_herrajes->items(),
            'links' => [
                'current_page' => $productos_herrajes->currentPage(),
                'last_page' => $productos_herrajes->lastPage(),
                'next_page_url' => $productos_herrajes->nextPageUrl(),
                'prev_page_url' => $productos_herrajes->previousPageUrl(),
            ]
        ]);
    }

    ////////////////////////////////////////////////// VIDRIOS

    public function catalogo_vidrios()
    {
        $productos_vidrio = DB::table('productos_vidrio')
            ->join('vidrio_tonalidades', 'productos_vidrio.id_tonalidad', '=', 'vidrio_tonalidades.id')
            ->join('vidrio_mm', 'productos_vidrio.id_mm', '=', 'vidrio_mm.id')
            ->join('precios_vidrio', 'precios_vidrio.id_producto', '=', 'productos_vidrio.id')
            ->leftJoin('stock_vidrio', 'stock_vidrio.id_producto', '=', 'productos_vidrio.id')
            ->select(
                'productos_vidrio.id as id',
                'productos_vidrio.id_categoria_producto as idc',
                'vidrio_tonalidades.id as id_tonalidad',
                'vidrio_tonalidades.descripcion as tonalidad',
                'vidrio_mm.id as id_mm',
                'vidrio_mm.mm as mm',
                'vidrio_tonalidades.imagen as imagen',
                'precios_vidrio.precio_venta_hoja as precio_hoja',
                'stock_vidrio.hojas as stock_cantidad',
            )
            ->paginate(6);

        $vidrio_tonalidades = vidrio_tonalidades::all();
        $vidrio_mm = vidrio_mm::all();

        return view('catalogo_vidrios', compact('productos_vidrio', 'vidrio_tonalidades', 'vidrio_mm'));
    }

    public function ficha_tecnica_vidrios($id)
    {
        $producto_vidrio = DB::table('productos_vidrio')
            ->join('vidrio_tonalidades', 'productos_vidrio.id_tonalidad', '=', 'vidrio_tonalidades.id')
            ->join('vidrio_mm', 'productos_vidrio.id_mm', '=', 'vidrio_mm.id')
            ->join('precios_vidrio', 'precios_vidrio.id_producto', '=', 'productos_vidrio.id')
            ->leftJoin('stock_vidrio', 'stock_vidrio.id_producto', '=', 'productos_vidrio.id')
            ->select(
                'productos_vidrio.id as id',
                'productos_vidrio.id_categoria_producto as idc',
                'vidrio_tonalidades.id as id_tonalidad',
                'vidrio_tonalidades.descripcion as tonalidad',
                'vidrio_mm.id as id_mm',
                'vidrio_mm.mm as mm',
                'vidrio_tonalidades.imagen as imagen',
                'precios_vidrio.precio_venta_hoja as precio_hoja',
                'stock_vidrio.hojas as stock_cantidad',
            )
            ->where('productos_vidrio.id', '=', $id)
            ->get();

        return view('ficha_tecnica_vidrios', compact('producto_vidrio'));
    }

    public function filtrarProductosVidrios(Request $request)
    {
        $query = DB::table('productos_vidrio')
            ->join('vidrio_tonalidades', 'productos_vidrio.id_tonalidad', '=', 'vidrio_tonalidades.id')
            ->join('vidrio_mm', 'productos_vidrio.id_mm', '=', 'vidrio_mm.id')
            ->join('precios_vidrio', 'precios_vidrio.id_producto', '=', 'productos_vidrio.id')
            ->leftJoin('stock_vidrio', 'stock_vidrio.id_producto', '=', 'productos_vidrio.id')
            ->select(
                'productos_vidrio.id as id',
                'productos_vidrio.id_categoria_producto as idc',
                'vidrio_tonalidades.id as id_tonalidad',
                'vidrio_tonalidades.descripcion as tonalidad',
                'vidrio_mm.id as id_mm',
                'vidrio_mm.mm as mm',
                'vidrio_tonalidades.imagen as imagen',
                'precios_vidrio.precio_venta_hoja as precio_hoja',
                'stock_vidrio.hojas as stock_cantidad',
            );

        // Filtro por tonalidad
        if ($request->filled('tonalidad')) {
            $query->where('vidrio_tonalidades.id', $request->tonalidad);
        }

        // Filtro por mm
        if ($request->filled('mm')) {
            $query->where('vidrio_mm.id', $request->mm);
        }

        // Filtro por búsqueda
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('vidrio_mm.mm', 'like', '%' . $request->search . '%')
                    ->orWhere('vidrio_tonalidades.descripcion', 'like', '%' . $request->search . '%');
            });
        }


        // Paginación
        $productos_vidrio = $query->paginate(6);

        return response()->json([
            'data' => $productos_vidrio->items(),
            'links' => [
                'current_page' => $productos_vidrio->currentPage(),
                'last_page' => $productos_vidrio->lastPage(),
                'next_page_url' => $productos_vidrio->nextPageUrl(),
                'prev_page_url' => $productos_vidrio->previousPageUrl(),
            ]
        ]);
    }
}
