<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        $users = $query->orderBy('id', 'desc')->get();

        if ($request->wantsJson()) {
            return response()->json($users);
        }

        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $user], 201);
        }

        return redirect()->back()
            ->with('success', 'El usuario "' . $user->name . '" fue registrado exitosamente.')
            ->with('title', '¡Usuario Creado!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $user]);
        }

        return redirect()->back()
            ->with('success', 'Los datos del usuario "' . $user->name . '" fueron actualizados exitosamente.')
            ->with('title', '¡Usuario Actualizado!');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $name = $user->name;

        // Evitar que un usuario se elimine a sí mismo si se usara autenticación
        if (auth()->check() && auth()->id() == $user->id) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'No puedes eliminar tu propio usuario en sesión.'], 403);
            }
            return redirect()->back()
                ->with('error', 'No puedes eliminar tu propia cuenta mientras estás con la sesión activa.')
                ->with('title', 'Acción no permitida');
        }

        $user->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()
            ->with('success', 'El usuario "' . $name . '" fue eliminado exitosamente.')
            ->with('title', '¡Usuario Eliminado!');
    }
}
