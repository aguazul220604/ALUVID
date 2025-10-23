<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\lineas;
use App\Models\tipos_aluminio;
use App\Models\productos_aluminio;
use App\Models\stock_aluminio;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\Inventario;

class GestionAluminiosController extends Controller
{
    public function aluminio_productos()
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
                'stock_aluminio.cantidad_metros as metros_lienales',
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

        return view('admin.productos_aluminios', compact('productos_aluminio', 'lineas_aluminio', 'tipos_aluminio', 'user'));
    }

    public function aluminio_add_product(Request $request)
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
        $producto_aluminio_nuevo = new productos_aluminio();
        $producto_aluminio_nuevo->codigo = $request->input('codigo');
        $producto_aluminio_nuevo->producto = $request->input('producto');
        $producto_aluminio_nuevo->imagen = $imagePath;

        // Buscar tipo
        $aluminio_linea = $request->input('linea');
        $aluminio_serie = $request->input('serie');

        $producto_aluminio_tipo = tipos_aluminio::where('id_linea', $aluminio_linea)
            ->where('id_serie', $aluminio_serie)
            ->first();

        $producto_aluminio_nuevo->id_tipo = $producto_aluminio_tipo?->id ?? null;

        // Guardar producto y stock
        if ($producto_aluminio_nuevo->save()) {
            $aluminio_stock_nuevo = new stock_aluminio();
            $aluminio_stock_nuevo->id_producto = $producto_aluminio_nuevo->id;
            $aluminio_stock_nuevo->save();

            return back()->with('message', 'ok');
        }

        return back()->with('message', 'error');
    }

    public function aluminio_delete_product($id)
    {
        $producto_aluminio = productos_aluminio::findOrFail($id);

        $stock_aluminio = stock_aluminio::where('id_producto', $id)->first();

        if ($stock_aluminio) {
            $stock_aluminio->delete();
        }

        // Verificar si el registro tiene una imagen
        if ($producto_aluminio->imagen) {
            $imagePath = public_path($producto_aluminio->imagen); // Ruta completa de la imagen

            // Comprobar si la imagen existe en el servidor antes de eliminarla
            if (file_exists($imagePath)) {
                unlink($imagePath); // Eliminar la imagen
            }
        }

        // Eliminar el registro de la base de datos
        $producto_aluminio->delete();

        return back()->with('message', 'deleted');
    }


    public function aluminio_update_product(Request $request)
    {
        // Validar datos
        $request->validate([
            'codigo' => 'required|string|max:500',
            'producto' => 'required|string|max:500',
            'linea' => 'required',
            'serie' => 'required',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:6144'
        ]);

        $producto_aluminio_actualizar = productos_aluminio::find($request->input('producto_id'));

        if (!$producto_aluminio_actualizar) {
            return back()->with('message', 'not_found');
        }

        // Imagen
        if ($request->hasFile('imagen')) {
            try {
                if ($producto_aluminio_actualizar->imagen && file_exists(public_path($producto_aluminio_actualizar->imagen))) {
                    unlink(public_path($producto_aluminio_actualizar->imagen));
                }
            } catch (\Exception $e) {
            }

            $imageName = Str::random(10) . '.' . $request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(public_path('images'), $imageName);
            $producto_aluminio_actualizar->imagen = 'images/' . $imageName;
        }

        // Datos
        $producto_aluminio_actualizar->codigo = $request->input('codigo');
        $producto_aluminio_actualizar->producto = $request->input('producto');

        // Tipo
        $aluminio_linea = $request->input('linea');
        $aluminio_serie = $request->input('serie');

        $producto_aluminio_tipo = tipos_aluminio::where('id_linea', $aluminio_linea)
            ->where('id_serie', $aluminio_serie)
            ->first();

        $producto_aluminio_actualizar->id_tipo = $producto_aluminio_tipo?->id ?? null;

        if ($producto_aluminio_actualizar->save()) {
            return back()->with('message', 'update');
        }

        return back()->with('message', 'error');
    }

    public function aluminio_stock_product(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|integer|exists:stock_aluminio,id_producto',
            'cantidad' => 'required|min:0',
        ]);

        $aluminio_stock_update = stock_aluminio::where('id_producto', $request->input('producto_id'))->firstOrFail();

        $aluminio_stock_update->piezas = $request->input('cantidad') + $request->input('stock');

        if ($aluminio_stock_update->save()) {

            $producto = DB::table('productos_aluminio')->where('id', $request->input('producto_id'))->first();
            $categoria = 'Aluminios';
            $user = User::where('role', 2)->first();
            $user->notify(new Inventario($producto, $categoria));

            return back()->with('message', 'update_stock');
        }

        return back()->with('message', 'error');
    }
}
