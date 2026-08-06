<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Ganado;
use App\Models\Usuario;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $query = Venta::with(['animal', 'usuario']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('contraparte', 'like', "%{$buscar}%")
                  ->orWhereHas('animal', function($qAnimal) use ($buscar) {
                      $qAnimal->where('arete', 'like', "%{$buscar}%")
                              ->orWhere('nombre', 'like', "%{$buscar}%");
                  });
            });
        }

        if ($request->filled('tipo_movimiento')) {
            $query->where('tipo_movimiento', $request->tipo_movimiento);
        }

        $ventas = $query->orderBy('id_venta', 'desc')->get();
        $animales = Ganado::orderBy('arete', 'asc')->get();
        $usuarios = Usuario::orderBy('nombre_completo', 'asc')->get();

        if ($request->wantsJson()) {
            return response()->json($ventas);
        }

        return view('ventas.index', compact('ventas', 'animales', 'usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_animal' => 'required|integer',
            'tipo_movimiento' => 'required|in:venta,compra,muerte,baja',
            'fecha_movimiento' => 'required|date',
            'contraparte' => 'nullable|string|max:100',
            'precio' => 'nullable|numeric|min:0',
            'id_usuario_registro' => 'nullable|integer',
        ]);

        if (empty($validated['id_usuario_registro'])) {
            $validated['id_usuario_registro'] = Usuario::first()->id_usuario ?? 1;
        }

        $movimiento = Venta::create($validated);

        // Si el tipo de movimiento es 'venta', 'muerte' o 'baja', actualizar opcionalmente el estatus del animal
        $animal = Ganado::find($validated['id_animal']);
        if ($animal) {
            if ($validated['tipo_movimiento'] === 'venta') {
                $animal->update(['estatus' => 'Vendido']);
            } elseif (in_array($validated['tipo_movimiento'], ['muerte', 'baja'])) {
                $animal->update(['estatus' => 'Fallecido']);
            }
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $movimiento], 201);
        }

        return redirect()->back()
            ->with('success', 'Movimiento de ' . ucfirst($movimiento->tipo_movimiento) . ' registrado exitosamente.')
            ->with('title', '¡Movimiento Registrado!');
    }

    public function update(Request $request, $id)
    {
        $movimiento = Venta::findOrFail($id);

        $validated = $request->validate([
            'id_animal' => 'required|integer',
            'tipo_movimiento' => 'required|in:venta,compra,muerte,baja',
            'fecha_movimiento' => 'required|date',
            'contraparte' => 'nullable|string|max:100',
            'precio' => 'nullable|numeric|min:0',
            'id_usuario_registro' => 'nullable|integer',
        ]);

        if (empty($validated['id_usuario_registro'])) {
            $validated['id_usuario_registro'] = $movimiento->id_usuario_registro;
        }

        $movimiento->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $movimiento]);
        }

        return redirect()->back()
            ->with('success', 'El registro de movimiento fue modificado exitosamente.')
            ->with('title', '¡Movimiento Modificado!');
    }

    public function destroy(Request $request, $id)
    {
        $movimiento = Venta::findOrFail($id);
        $movimiento->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()
            ->with('success', 'El movimiento fue eliminado exitosamente.')
            ->with('title', '¡Registro Eliminado!');
    }
}
