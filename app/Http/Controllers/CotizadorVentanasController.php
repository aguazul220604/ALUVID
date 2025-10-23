<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\aberturas;
use Illuminate\Support\Facades\DB;

class CotizadorVentanasController extends Controller
{
    public function inicio()
    {
        $aberturas = aberturas::all();

        // Componentes de aluminio agrupados por abertura
        $aluminios = DB::table('abertura_componentes_aluminio')
            ->join('productos_aluminio', 'abertura_componentes_aluminio.id_producto_aluminio', '=', 'productos_aluminio.id')
            ->join('aberturas', 'abertura_componentes_aluminio.id_abertura', '=', 'aberturas.id')
            ->select(
                'abertura_componentes_aluminio.id_abertura',
                'productos_aluminio.id',
                'productos_aluminio.codigo',
                'productos_aluminio.producto',
                'productos_aluminio.precio',
                'productos_aluminio.imagen',
                'aberturas.base',
                'aberturas.altura',
                'abertura_componentes_aluminio.cantidad_producto_aluminio'
            )
            ->get()
            ->groupBy('id_abertura');

        // Componentes de herrajes agrupados por abertura
        $herrajes = DB::table('abertura_componentes_herrajes')
            ->join('productos_herrajes', 'abertura_componentes_herrajes.id_producto_herrajes', '=', 'productos_herrajes.id')
            ->select(
                'abertura_componentes_herrajes.id_abertura',
                'productos_herrajes.id',
                'productos_herrajes.codigo',
                'productos_herrajes.producto',
                'productos_herrajes.precio',
                'productos_herrajes.imagen',
                'abertura_componentes_herrajes.cantidad_producto_herrajes'
            )
            ->get()
            ->groupBy('id_abertura');
        return view('cotizador_ventanas', [
            'aberturas' => $aberturas,
            'aluminiosPorAbertura' => $aluminios,
            'herrajesPorAbertura' => $herrajes
        ]);
    }
}
