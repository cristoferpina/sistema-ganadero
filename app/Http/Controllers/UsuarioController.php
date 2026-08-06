<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre_completo', 'like', "%{$buscar}%")
                  ->orWhere('nombre_usuario', 'like', "%{$buscar}%")
                  ->orWhere('correo', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }

        $usuarios = $query->orderBy('id_usuario', 'desc')->get();

        if ($request->wantsJson()) {
            return response()->json($usuarios);
        }

        return view('usuarios.index', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'nombre_usuario' => 'required|string|max:50|unique:Usuarios,nombre_usuario',
            'contrasena' => 'required|string|min:4',
            'rol' => 'required|in:administrador,operador',
            'correo' => 'nullable|email|max:100',
            'estatus' => 'required|in:activo,inactivo',
        ]);

        $validated['contrasena'] = Hash::make($validated['contrasena']);

        $usuario = Usuario::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $usuario], 201);
        }

        return redirect()->back()
            ->with('success', 'El usuario "' . $usuario->nombre_completo . '" (@' . $usuario->nombre_usuario . ') fue creado exitosamente.')
            ->with('title', '¡Usuario Creado!');
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'nombre_usuario' => ['required', 'string', 'max:50', Rule::unique('Usuarios', 'nombre_usuario')->ignore($usuario->id_usuario, 'id_usuario')],
            'contrasena' => 'nullable|string|min:4',
            'rol' => 'required|in:administrador,operador',
            'correo' => 'nullable|email|max:100',
            'estatus' => 'required|in:activo,inactivo',
        ]);

        if (!empty($validated['contrasena'])) {
            $validated['contrasena'] = Hash::make($validated['contrasena']);
        } else {
            unset($validated['contrasena']);
        }

        $usuario->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $usuario]);
        }

        return redirect()->back()
            ->with('success', 'El usuario "' . $usuario->nombre_completo . '" fue actualizado exitosamente.')
            ->with('title', '¡Usuario Actualizado!');
    }

    public function destroy(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $nombre = $usuario->nombre_completo;
        $usuario->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()
            ->with('success', 'El usuario "' . $nombre . '" fue eliminado exitosamente.')
            ->with('title', '¡Usuario Eliminado!');
    }
}
