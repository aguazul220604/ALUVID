<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdministradorController extends Controller
{
    public function inicio()
    {
        $user = Auth::user();
        session()->flash('reset_menu', true); // << Esto asegura que "Inicio" sea seleccionado
        return view('admin.inicio', compact('user'));
    }


    public function usuarios()
    {
        $user = Auth::user();
        $users = User::all();
        return view('admin.usuarios', compact('user', 'users'));
    }

    public function usuarios_update(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:500',
        ]);

        $id = $request->input('id');

        $user = User::findOrFail($id);

        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->email = $request->input('email');

        if ($user->save()) {
            return back()->with('message', 'update');
        }

        return back()->with('message', 'error');
    }
}
