<?php

namespace App\Http\Controllers;

use App\Models\lineas;
use App\Models\series_aluminio;
use App\Models\series_herrajes;
use App\Models\tipos_aluminio;
use App\Models\tipos_herrajes;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\vidrio_tonalidades;
use App\Models\vidrio_mm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function Pest\Laravel\delete;

class ProductosGestionAdminController extends Controller
{

    /////////////////////////////////////////////////////////// Vidrios

    public function gestion_vidrio_admin_show()
    {
        $user = Auth::user();
        $vidrio_tonalidades = vidrio_tonalidades::all();
        $vidrio_mm = vidrio_mm::orderBy('mm', 'desc')->get();
        return view('admin.gestion_vidrios', compact('user', 'vidrio_tonalidades', 'vidrio_mm'));
    }

    public function gestion_vidrio_admin_create_tonalidad(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
        ]);

        if ($request->hasFile('img')) {
            $imageName = Str::random(10) . '.' . $request->file('img')->getClientOriginalExtension();
            $request->file('img')->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        } else {
            $imagePath = null;
        }

        $tonalidad_nueva = new vidrio_tonalidades();
        $tonalidad_nueva->descripcion = $request->input('descripcion');
        $tonalidad_nueva->imagen = $imagePath;

        if ($tonalidad_nueva->save()) {
            return back()->with('message', 'ok1');
        }

        return back()->with('message', 'error');
    }

    public function gestion_vidrio_admin_update_tonalidad(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
        ]);

        $tonalidad = vidrio_tonalidades::find($id);

        if (!$tonalidad) {
            return back()->with('message', 'error: tonalidad no encontrada');
        }

        $tonalidad->descripcion = $request->input('descripcion');

        if ($request->hasFile('imagen')) {
            if ($tonalidad->imagen && file_exists(public_path($tonalidad->imagen))) {
                unlink(public_path($tonalidad->imagen));
            }

            $imageName = Str::random(10) . '.' . $request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(public_path('images'), $imageName);
            $tonalidad->imagen = 'images/' . $imageName;
        }

        if ($tonalidad->save()) {
            return back()->with('message', 'update1');
        }

        return back()->with('message', 'error');
    }

    public function gestion_vidrio_admin_delete_tonalidad($id)
    {
        $tonalidad = vidrio_tonalidades::findOrFail($id);

        if ($tonalidad->imagen) {
            $imagePath = public_path($tonalidad->imagen);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $tonalidad->delete();

        return back()->with('message', 'deleted');
    }

    public function gestion_vidrio_admin_create_mm(Request $request)
    {
        $request->validate([
            'mm' => 'required|integer|min:1',
        ]);

        $mm_nuevo = new vidrio_mm();
        $mm_nuevo->mm = $request->input('mm');

        if ($mm_nuevo->save()) {
            return back()->with('message', 'ok2');
        }

        return back()->with('message', 'error');
    }

    public function gestion_vidrio_admin_delete_mm($id)
    {
        $mm = vidrio_mm::findOrFail($id);

        $mm->delete();

        return back()->with('message', 'deleted');
    }

    /////////////////////////////////////////////////////////// Aluminio

    public function gestion_aluminio_admin_show()
    {
        $user = Auth::user();

        $productos_aluminio = DB::table('lineas')
            ->leftJoin('tipos_aluminio', 'lineas.id', '=', 'tipos_aluminio.id_linea')
            ->leftJoin('series_aluminio', 'tipos_aluminio.id_serie', '=', 'series_aluminio.id')
            ->select(
                'lineas.id as id_linea',
                'lineas.descripcion as linea',
                'series_aluminio.id as id_serie',
                'series_aluminio.descripcion as serie'
            )
            ->orderBy('lineas.id')
            ->get();



        $lineas = DB::table('lineas')
            ->select('lineas.id', 'lineas.descripcion', 'lineas.categoria')
            ->where(function ($q) {
                $q->where('lineas.categoria', '2')
                    ->orWhere(function ($q2) {
                        $q2->where('lineas.categoria', '3')
                            ->whereExists(function ($sub) {
                                $sub->select(DB::raw(1))
                                    ->from('tipos_aluminio')
                                    ->whereColumn('tipos_aluminio.id_linea', 'lineas.id');
                            });
                    });
            })
            ->get();


        return view('admin.gestion_aluminios', compact('user', 'productos_aluminio', 'lineas'));
    }

    public function gestion_aluminio_admin_create_serie(Request $request)
    {
        $request->validate([
            'id_linea' => 'required|integer|exists:lineas,id',
            'descripcion' => 'required|string|max:255',
        ]);

        $serie = new series_aluminio();
        $serie->descripcion = $request->descripcion;
        $serie->save();

        $tipo = new tipos_aluminio();
        $tipo->id_linea = $request->id_linea;
        $tipo->id_serie = $serie->id;
        $tipo->save();

        return back()->with('message', 'ok1');
    }

    public function gestion_aluminio_admin_update_serie(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $serie = series_aluminio::find($id);

        $serie->descripcion = $request->input('descripcion');

        if ($serie->save()) {
            return back()->with('message', 'update1');
        }

        return back()->with('message', 'error');
    }

    public function gestion_aluminio_admin_delete_serie($id)
    {
        $serie = series_aluminio::findOrFail($id);

        $serie->delete();

        return back()->with('message', 'deleted');
    }

    public function gestion_aluminio_admin_create_linea(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $linea = new lineas();
        $linea->descripcion = $request->descripcion;
        $linea->categoria = $request->categoria;

        if ($linea->save()) {
            return back()->with('message', 'ok2');
        }
        return back()->with('message', 'deleted');
    }

    public function gestion_aluminio_admin_delete_linea($id)
    {
        $linea = lineas::findOrFail($id);

        $linea->delete();

        return back()->with('message', 'deleted');
    }

    /////////////////////////////////////////////////////////// Herrajes

    public function gestion_herrajes_admin_show()
    {
        $user = Auth::user();

        $productos_herrajes = DB::table('lineas')
            ->leftJoin('tipos_herrajes', 'lineas.id', '=', 'tipos_herrajes.id_linea')
            ->leftJoin('series_herrajes', 'tipos_herrajes.id_serie', '=', 'series_herrajes.id')
            ->select(
                'lineas.id as id_linea',
                'lineas.descripcion as linea',
                'series_herrajes.id as id_serie',
                'series_herrajes.descripcion as serie'
            )
            ->orderBy('lineas.id')
            ->get();



        $lineas = DB::table('lineas')
            ->select('lineas.id', 'lineas.descripcion', 'lineas.categoria')
            ->where(function ($q) {
                $q->where('lineas.categoria', '1')
                    ->orWhere(function ($q2) {
                        $q2->where('lineas.categoria', '3')
                            ->whereExists(function ($sub) {
                                $sub->select(DB::raw(1))
                                    ->from('tipos_herrajes')
                                    ->whereColumn('tipos_herrajes.id_linea', 'lineas.id');
                            });
                    });
            })
            ->get();


        return view('admin.gestion_herrajes', compact('user', 'productos_herrajes', 'lineas'));
    }

    public function gestion_herrajes_admin_create_serie(Request $request)
    {
        $request->validate([
            'id_linea' => 'required|integer|exists:lineas,id',
            'descripcion' => 'required|string|max:255',
        ]);

        $serie = new series_herrajes();
        $serie->descripcion = $request->descripcion;
        $serie->save();

        $tipo = new tipos_herrajes();
        $tipo->id_linea = $request->id_linea;
        $tipo->id_serie = $serie->id;
        $tipo->save();

        return back()->with('message', 'ok1');
    }

    public function gestion_herrajes_admin_update_serie(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $serie = series_herrajes::find($id);

        $serie->descripcion = $request->input('descripcion');

        if ($serie->save()) {
            return back()->with('message', 'update1');
        }

        return back()->with('message', 'error');
    }

    public function gestion_herrajes_admin_delete_serie($id)
    {
        $serie = series_herrajes::findOrFail($id);

        $serie->delete();

        return back()->with('message', 'deleted');
    }

    public function gestion_herrajes_admin_create_linea(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $linea = new lineas();
        $linea->descripcion = $request->descripcion;
        $linea->categoria = $request->categoria;

        if ($linea->save()) {
            return back()->with('message', 'ok2');
        }
        return back()->with('message', 'deleted');
    }

    public function gestion_herrajes_admin_delete_linea($id)
    {
        $linea = lineas::findOrFail($id);

        $linea->delete();

        return back()->with('message', 'deleted');
    }
}
