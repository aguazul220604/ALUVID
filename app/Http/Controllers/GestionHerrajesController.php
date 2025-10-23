<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\lineas;
use App\Models\tipos_herrajes;
use App\Models\productos_herrajes;
use App\Models\stock_herrajes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\Inventario;

class GestionHerrajesController extends Controller
{

    public function herrajes_productos()
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

        return view('admin.productos_herrajes', compact('productos_herrajes', 'lineas_herrajes', 'tipos_herrajes', 'user'));
    }

    public function herrajes_add_product(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'codigo' => 'required|string|max:500',
            'producto' => 'required|string|max:500',
            'linea' => 'required',
            'serie' => 'required',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:6144'
        ]);

        // Manejar la subida de la imagen
        if ($request->hasFile('imagen')) {
            $imageName = Str::random(10) . '.' . $request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        } else {
            $imagePath = null;
        }

        // Crear nueva instancia de producto
        $producto_herrajes_nuevo = new productos_herrajes();
        $producto_herrajes_nuevo->codigo = $request->input('codigo');
        $producto_herrajes_nuevo->producto = $request->input('producto');
        $producto_herrajes_nuevo->imagen = $imagePath;

        // Buscar tipo
        $herrajes_linea = $request->input('linea');
        $herrajes_serie = $request->input('serie');

        $producto_herrajes_tipo = tipos_herrajes::where('id_linea', $herrajes_linea)
            ->where('id_serie', $herrajes_serie)
            ->first();

        $producto_herrajes_nuevo->id_tipo = $producto_herrajes_tipo?->id ?? null;

        // Guardar producto y stock
        if ($producto_herrajes_nuevo->save()) {
            $herrajes_stock_nuevo = new stock_herrajes();
            $herrajes_stock_nuevo->id_producto = $producto_herrajes_nuevo->id;
            $herrajes_stock_nuevo->save();

            return back()->with('message', 'ok');
        }

        return back()->with('message', 'error');
    }

    public function herrajes_delete_product($id)
    {
        $producto_herrajes = productos_herrajes::findOrFail($id);

        $stock_herrajes = stock_herrajes::where('id_producto', $id)->first();

        if ($stock_herrajes) {
            $stock_herrajes->delete();
        }

        // Verificar si el registro tiene una imagen
        if ($producto_herrajes->imagen) {
            $imagePath = public_path($producto_herrajes->imagen); // Ruta completa de la imagen

            // Comprobar si la imagen existe en el servidor antes de eliminarla
            if (file_exists($imagePath)) {
                unlink($imagePath); // Eliminar la imagen
            }
        }

        // Eliminar el registro de la base de datos
        $producto_herrajes->delete();

        return back()->with('message', 'deleted');
    }

    public function herrajes_update_product(Request $request)
    {
        // Validar datos
        $request->validate([
            'codigo' => 'required|string|max:500',
            'producto' => 'required|string|max:500',
            'linea' => 'required',
            'serie' => 'required',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:6144'
        ]);

        $producto_herrajes_actualizar = productos_herrajes::find($request->input('producto_id'));

        if (!$producto_herrajes_actualizar) {
            return back()->with('message', 'not_found');
        }

        // Imagen
        if ($request->hasFile('imagen')) {
            try {
                if ($producto_herrajes_actualizar->imagen && file_exists(public_path($producto_herrajes_actualizar->imagen))) {
                    unlink(public_path($producto_herrajes_actualizar->imagen));
                }
            } catch (\Exception $e) {
            }

            $imageName = Str::random(10) . '.' . $request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(public_path('images'), $imageName);
            $producto_herrajes_actualizar->imagen = 'images/' . $imageName;
        }

        // Datos
        $producto_herrajes_actualizar->codigo = $request->input('codigo');
        $producto_herrajes_actualizar->producto = $request->input('producto');

        // Tipo
        $herrajes_linea = $request->input('linea');
        $herrajes_serie = $request->input('serie');

        $producto_herrajes_tipo = tipos_herrajes::where('id_linea', $herrajes_linea)
            ->where('id_serie', $herrajes_serie)
            ->first();

        $producto_herrajes_actualizar->id_tipo = $producto_herrajes_tipo?->id ?? null;

        if ($producto_herrajes_actualizar->save()) {
            return back()->with('message', 'update');
        }

        return back()->with('message', 'error');
    }

    public function herrajes_stock_product(Request $request)
    {
        // Validación
        $request->validate([
            'producto_id' => 'required|integer|exists:stock_herrajes,id_producto',
            'cantidad' => 'required|integer|min:0',
        ]);

        // Buscar y actualizar
        $herrajes_stock_update = stock_herrajes::where('id_producto', $request->input('producto_id'))->firstOrFail();
        $herrajes_stock_update->cantidad = $request->input('cantidad') + $request->input('stock');

        if ($herrajes_stock_update->save()) {

            $producto = DB::table('productos_herrajes')->where('id', $request->input('producto_id'))->first();
            $categoria = 'Herrajes';
            $user = User::where('role', 2)->first();
            $user->notify(new Inventario($producto, $categoria));

            return back()->with('message', 'update_stock');
        }

        return back()->with('message', 'error');
    }
}
