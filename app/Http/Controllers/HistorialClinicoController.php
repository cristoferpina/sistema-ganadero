<?php

namespace App\Http\Controllers;

use App\Models\HistorialClinico;
use App\Models\Ganado;
use App\Models\Usuario;
use Illuminate\Http\Request;

class HistorialClinicoController extends Controller
{
    public function index(Request $request)
    {
        $query = HistorialClinico::with(['animal', 'usuario']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre_producto', 'like', "%{$buscar}%")
                  ->orWhereHas('animal', function($qAnimal) use ($buscar) {
                      $qAnimal->where('arete', 'like', "%{$buscar}%")
                              ->orWhere('nombre', 'like', "%{$buscar}%");
                  });
            });
        }

        if ($request->filled('tipo_evento')) {
            $query->where('tipo_evento', $request->tipo_evento);
        }

        $historiales = $query->orderBy('id_historial', 'desc')->get();
        $animales = Ganado::orderBy('arete', 'asc')->get();
        $usuarios = Usuario::orderBy('nombre_completo', 'asc')->get();

        if ($request->wantsJson()) {
            return response()->json($historiales);
        }

        return view('historial_clinico.index', compact('historiales', 'animales', 'usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_animal' => 'required|integer',
            'tipo_evento' => 'required|in:vacuna,desparasitacion,tratamiento',
            'nombre_producto' => 'required|string|max:100',
            'dosis' => 'nullable|string|max:30',
            'fecha_aplicacion' => 'required|date',
            'fecha_proxima_aplicacion' => 'nullable|date',
            'id_usuario' => 'nullable|integer',
        ]);

        if (empty($validated['id_usuario'])) {
            $validated['id_usuario'] = Usuario::first()->id_usuario ?? 1;
        }

        $registro = HistorialClinico::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $registro], 201);
        }

        return redirect()->back()
            ->with('success', 'Evento clínico de ' . ucfirst($registro->tipo_evento) . ' (' . $registro->nombre_producto . ') guardado exitosamente.')
            ->with('title', '¡Historial Registrado!');
    }

    public function update(Request $request, $id)
    {
        $registro = HistorialClinico::findOrFail($id);

        $validated = $request->validate([
            'id_animal' => 'required|integer',
            'tipo_evento' => 'required|in:vacuna,desparasitacion,tratamiento',
            'nombre_producto' => 'required|string|max:100',
            'dosis' => 'nullable|string|max:30',
            'fecha_aplicacion' => 'required|date',
            'fecha_proxima_aplicacion' => 'nullable|date',
            'id_usuario' => 'nullable|integer',
        ]);

        if (empty($validated['id_usuario'])) {
            $validated['id_usuario'] = $registro->id_usuario;
        }

        $registro->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $registro]);
        }

        return redirect()->back()
            ->with('success', 'El evento clínico de ' . $registro->nombre_producto . ' fue actualizado exitosamente.')
            ->with('title', '¡Historial Modificado!');
    }

    public function destroy(Request $request, $id)
    {
        $registro = HistorialClinico::findOrFail($id);
        $producto = $registro->nombre_producto;
        $registro->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()
            ->with('success', 'El evento clínico (' . $producto . ') fue eliminado exitosamente.')
            ->with('title', '¡Historial Eliminado!');
    }
}
