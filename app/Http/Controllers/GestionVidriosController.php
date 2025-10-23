<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\vidrio_tonalidades;
use App\Models\vidrio_mm;
use App\Models\productos_vidrio;
use App\Models\stock_vidrio;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\Inventario;

class GestionVidriosController extends Controller
{
    public function vidrio_productos()
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

        return view('admin.productos_vidrios', compact('user', 'productos_vidrio', 'vidrio_tonalidades', 'vidrio_mm', 'tipos_tonalidades'));
    }

    public function vidrio_add_product(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'tonalidad' => 'required',
            'mm' => 'required'
        ]);

        if (productos_vidrio::where('id_tonalidad', $request->input('tonalidad'))
            ->where('id_mm', $request->input('mm'))
            ->exists()
        ) {
            return back()->with('message', 'existe');
        }

        $producto_vidrio_nuevo = new productos_vidrio();
        $producto_vidrio_nuevo->id_tonalidad = $request->input('tonalidad');
        $producto_vidrio_nuevo->id_mm = $request->input('mm');

        if ($producto_vidrio_nuevo->save()) {
            $vidrio_stock_nuevo = new stock_vidrio();
            $vidrio_stock_nuevo->id_producto = $producto_vidrio_nuevo->id;
            $vidrio_stock_nuevo->save();

            return back()->with('message', 'ok');
        }

        return back()->with('message', 'error');
    }

    public function vidrio_update_product(Request $request)
    {
        // Validar datos
        $request->validate([
            'tonalidad' => 'required',
            'mm' => 'required'
        ]);

        $producto_vidrio_actualizar = productos_vidrio::find($request->input('producto_id'));

        // Datos
        $producto_vidrio_actualizar->id_tonalidad = $request->input('tonalidad');
        $producto_vidrio_actualizar->id_mm = $request->input('mm');

        if (productos_vidrio::where('id_tonalidad', $request->input('tonalidad'))
            ->where('id_mm', $request->input('mm'))
            ->exists()
        ) {
            return back()->with('message', 'existe');
        } else {
            $producto_vidrio_actualizar->save();
            return back()->with('message', 'update');
        }

        return back()->with('message', 'error');
    }

    public function vidrio_delete_product($id)
    {
        $producto_vidrio = productos_vidrio::findOrFail($id);

        $stock_vidrio = stock_vidrio::where('id_producto', $id)->first();

        if ($stock_vidrio) {
            $stock_vidrio->delete();
        }
        // Eliminar el registro de la base de datos
        $producto_vidrio->delete();

        return back()->with('message', 'deleted');
    }

    public function vidrio_stock_product(Request $request)
    {
        // Validación
        $request->validate([
            'producto_id' => 'required|integer|exists:stock_vidrio,id_producto',
            'cantidad' => 'required|min:0',
        ]);

        // Buscar y actualizar
        $vidrio_stock_update = stock_vidrio::where('id_producto', $request->input('producto_id'))->firstOrFail();
        $vidrio_stock_update->hojas = $request->input('cantidad') + $request->input('stock');

        if ($vidrio_stock_update->save()) {

            $producto = DB::table('productos_vidrio')
                ->join('vidrio_tonalidades', 'productos_vidrio.id_tonalidad', '=', 'vidrio_tonalidades.id')
                ->join('vidrio_mm', 'productos_vidrio.id_mm', '=', 'vidrio_mm.id')
                ->select(
                    'vidrio_tonalidades.descripcion as tonalidad',
                    'vidrio_mm.mm as mm',
                )
                ->where('productos_vidrio.id', $request->input('producto_id'))->first();
            $categoria = 'Vidrios';
            $user = User::where('role', 2)->first();
            $user->notify(new Inventario($producto, $categoria));

            return back()->with('message', 'update_stock');
        }

        return back()->with('message', 'error');
    }
}
