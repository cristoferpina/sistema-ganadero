<?php

namespace App\Http\Controllers;

use App\Models\CicloReproductivo;
use App\Models\Ganado;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CicloReproductivoController extends Controller
{
    public function index(Request $request)
    {
        $query = CicloReproductivo::with(['madre', 'cria', 'usuario']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('madre', function ($q) use ($buscar) {
                $q->where('arete', 'like', "%{$buscar}%")
                  ->orWhere('nombre', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('tipo_monta')) {
            $query->where('tipo_monta', $request->tipo_monta);
        }

        $ciclos = $query->orderBy('id_ciclo', 'desc')->get();
        // Madres (Solo hembras)
        $hembras = Ganado::where('sexo', 'Hembra')->orderBy('arete', 'asc')->get();
        // Crías
        $animales = Ganado::orderBy('arete', 'asc')->get();
        $usuarios = Usuario::orderBy('nombre_completo', 'asc')->get();

        if ($request->wantsJson()) {
            return response()->json($ciclos);
        }

        return view('ciclo_reproductivo.index', compact('ciclos', 'hembras', 'animales', 'usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_madre' => 'required|integer',
            'tipo_monta' => 'required|in:natural,inseminacion',
            'fecha_monta' => 'required|date',
            'fecha_parto_estimada' => 'nullable|date',
            'fecha_parto_real' => 'nullable|date',
            'numero_crias' => 'nullable|integer|min:0',
            'id_cria' => 'nullable|integer',
            'fecha_destete' => 'nullable|date',
            'id_usuario_registro' => 'nullable|integer',
        ]);

        if (empty($validated['id_usuario_registro'])) {
            $validated['id_usuario_registro'] = Usuario::first()->id_usuario ?? 1;
        }

        // Si no se proveyó fecha de parto estimada, calcular aproximadamente +283 días para ganado bovino
        if (empty($validated['fecha_parto_estimada']) && !empty($validated['fecha_monta'])) {
            $validated['fecha_parto_estimada'] = date('Y-m-d', strtotime($validated['fecha_monta'] . ' +283 days'));
        }

        $ciclo = CicloReproductivo::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $ciclo], 201);
        }

        return redirect()->back()
            ->with('success', 'El registro de ciclo reproductivo fue guardado exitosamente.')
            ->with('title', '¡Ciclo Reproductivo Creado!');
    }

    public function update(Request $request, $id)
    {
        $ciclo = CicloReproductivo::findOrFail($id);

        $validated = $request->validate([
            'id_madre' => 'required|integer',
            'tipo_monta' => 'required|in:natural,inseminacion',
            'fecha_monta' => 'required|date',
            'fecha_parto_estimada' => 'nullable|date',
            'fecha_parto_real' => 'nullable|date',
            'numero_crias' => 'nullable|integer|min:0',
            'id_cria' => 'nullable|integer',
            'fecha_destete' => 'nullable|date',
            'id_usuario_registro' => 'nullable|integer',
        ]);

        if (empty($validated['id_usuario_registro'])) {
            $validated['id_usuario_registro'] = $ciclo->id_usuario_registro;
        }

        $ciclo->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'data' => $ciclo]);
        }

        return redirect()->back()
            ->with('success', 'El ciclo reproductivo fue modificado exitosamente.')
            ->with('title', '¡Ciclo Reproductivo Modificado!');
    }

    public function destroy(Request $request, $id)
    {
        $ciclo = CicloReproductivo::findOrFail($id);
        $ciclo->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()
            ->with('success', 'El ciclo reproductivo fue eliminado exitosamente.')
            ->with('title', '¡Registro Eliminado!');
    }
}
