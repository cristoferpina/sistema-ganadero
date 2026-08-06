<?php

namespace App\Http\Controllers;

use App\Models\Ganado;
use Illuminate\Http\Request;

class GanadoController extends Controller
{
    public function index(Request $request)
    {
        $query = Ganado::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('arete', 'like', "%{$buscar}%")
                  ->orWhere('nombre', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('estatus')) {
            $query->where('estatus', $request->estatus);
        }

        if ($request->filled('raza')) {
            $query->where('raza', $request->raza);
        }

        $ganados = $query->orderBy('id_animal', 'desc')->get();

        if ($request->wantsJson()) {
            return response()->json($ganados);
        }

        return view('ganado.index', compact('ganados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'arete' => 'required|string|unique:Ganado,arete',
            'nombre' => 'nullable|string|max:255',
            'raza' => 'required|string|max:255',
            'sexo' => 'required|in:Macho,Hembra',
            'fecha_nacimiento' => 'nullable|date',
            'peso_actual' => 'nullable|numeric|min:0',
            'categoria' => 'required|string|max:255',
            'estatus' => 'required|string|max:255',
            'id_madre' => 'nullable|integer',
        ]);

        $validated['id_usuario_registro'] = auth()->id() ?? 1;

        $ganado = Ganado::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $ganado], 201);
        }

        return redirect()->back()
            ->with('success', 'El registro del animal con Arete #' . $ganado->arete . ' fue guardado exitosamente.')
            ->with('title', '¡Registro Creado!');
    }

    public function update(Request $request, $id)
    {
        $ganado = Ganado::findOrFail($id);

        $validated = $request->validate([
            'arete' => 'required|string|unique:Ganado,arete,' . $id . ',id_animal',
            'nombre' => 'nullable|string|max:255',
            'raza' => 'required|string|max:255',
            'sexo' => 'required|in:Macho,Hembra',
            'fecha_nacimiento' => 'nullable|date',
            'peso_actual' => 'nullable|numeric|min:0',
            'categoria' => 'required|string|max:255',
            'estatus' => 'required|string|max:255',
            'id_madre' => 'nullable|integer',
        ]);

        $ganado->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $ganado]);
        }

        return redirect()->back()
            ->with('success', 'El registro del animal con Arete #' . $ganado->arete . ' fue modificado exitosamente.')
            ->with('title', '¡Registro Modificado!');
    }

    public function destroy(Request $request, $id)
    {
        $ganado = Ganado::findOrFail($id);
        $arete = $ganado->arete;
        $ganado->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()
            ->with('success', 'El registro del animal con Arete #' . $arete . ' fue eliminado exitosamente.')
            ->with('title', '¡Registro Eliminado!');
    }
}
