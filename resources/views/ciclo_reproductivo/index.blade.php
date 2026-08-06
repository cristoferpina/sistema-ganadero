@extends('layouts.app')

@section('title', 'Ciclos Reproductivos - Sistema Ganadero')

@section('content')
<div class="h-screen w-screen overflow-hidden flex flex-col bg-background">
    <!-- Top Navigation Bar Shell -->
    <nav class="fixed top-0 left-0 w-full flex justify-between items-center px-6 h-16 bg-surface border-b border-outline-variant shadow-sm z-30">
        <div class="flex items-center gap-4">
            <span class="font-bold text-xl text-primary flex items-center gap-2">
                <span class="material-symbols-outlined fill text-primary">pets</span>
                Sistema Ganadero
            </span>
        </div>
        <div class="flex-1 flex justify-end px-8">
            <div class="relative w-64 md:w-80">
                <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-on-surface-variant">search</span>
                <input id="top-search-input" type="text" placeholder="Buscar por arete de la madre..." 
                       class="w-full pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-system text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-on-surface placeholder:text-on-surface-variant"/>
            </div>
        </div>
    </nav>

    <!-- Side Navigation Shell -->
    <aside class="fixed left-0 top-0 h-full flex flex-col py-6 border-r border-outline-variant bg-surface-container w-64 pt-20 z-20">
        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('ganado.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-on-surface-variant hover:bg-surface-container-highest transition-all text-xs">
                <span class="material-symbols-outlined">pets</span> Ganado
            </a>
            <a href="{{ route('historial-clinico.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-on-surface-variant hover:bg-surface-container-highest transition-all text-xs">
                <span class="material-symbols-outlined">medical_services</span> Historial Clínico
            </a>
            <a href="{{ route('ciclo-reproductivo.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-primary font-semibold border-r-4 border-primary bg-surface-container-high text-xs">
                <span class="material-symbols-outlined fill">diversity_1</span> Ciclos Reproductivos
            </a>
            <a href="{{ route('ventas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-on-surface-variant hover:bg-surface-container-highest transition-all text-xs">
                <span class="material-symbols-outlined">payments</span> Ventas y Bajas
            </a>
            <a href="{{ route('usuarios.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-on-surface-variant hover:bg-surface-container-highest transition-all text-xs">
                <span class="material-symbols-outlined">manage_accounts</span> Usuarios
            </a>
        </nav>
        <div class="px-4 mt-auto space-y-1">
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-system text-on-surface-variant text-xs hover:bg-surface-container-highest transition-all">
                <span class="material-symbols-outlined">settings</span> Configuración
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="ml-64 pt-20 flex-1 bg-background p-8 overflow-y-auto z-10">
        <div class="max-w-[1440px] mx-auto space-y-6">
            <!-- Header Section -->
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Ciclos Reproductivos y Gestación</h1>
                    <p class="text-sm text-on-surface-variant mt-1">Control de montas, inseminación, parto estimado/real y destete de crías.</p>
                </div>
                <button onclick="abrirModalCrearCiclo()" class="bg-primary text-on-primary text-xs font-semibold px-5 py-2.5 rounded-system hover:bg-primary/90 transition-colors flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-sm">favorite</span>
                    Registrar Ciclo Reproductivo
                </button>
            </header>

            <!-- CRUD Module Container -->
            <div class="bg-surface-container-lowest rounded-system border border-outline-variant shadow-ambient-lvl1 overflow-hidden">
                <!-- Top Action Bar & Filters -->
                <form method="GET" action="{{ route('ciclo-reproductivo.index') }}" class="p-4 sm:p-6 border-b border-outline-variant bg-surface-container-lowest flex flex-col md:flex-row gap-3 sm:gap-4 items-stretch md:items-center justify-between">
                    <div class="relative w-full md:w-[260px] lg:w-[320px]">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por Arete de la Madre..." 
                               class="w-full pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-system text-xs sm:text-sm text-on-surface placeholder:text-on-surface-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"/>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 sm:gap-3 w-full md:w-auto">
                        <div class="relative flex-1 sm:flex-none">
                            <select name="tipo_monta" onchange="this.form.submit()" class="w-full sm:w-auto appearance-none bg-surface-container-low border border-outline-variant rounded-system pl-3 sm:pl-4 pr-9 py-2 text-xs sm:text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary min-w-[150px]">
                                <option value="">Todos los Tipos</option>
                                <option value="natural" {{ request('tipo_monta') == 'natural' ? 'selected' : '' }}>Monta Natural</option>
                                <option value="inseminacion" {{ request('tipo_monta') == 'inseminacion' ? 'selected' : '' }}>Inseminación</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">arrow_drop_down</span>
                        </div>

                        @if(request()->hasAny(['buscar', 'tipo_monta']))
                        <a href="{{ route('ciclo-reproductivo.index') }}" class="p-2 text-on-surface-variant hover:text-error transition-colors flex items-center" title="Limpiar filtros">
                            <span class="material-symbols-outlined">filter_alt_off</span>
                        </a>
                        @endif
                    </div>
                </form>

                <!-- Data Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse min-w-[1000px]">
                        <thead class="bg-surface-container-low text-xs text-on-surface-variant uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-semibold w-16">ID</th>
                                <th class="px-6 py-4 font-semibold">Madre (Vaca)</th>
                                <th class="px-6 py-4 font-semibold">Tipo Monta</th>
                                <th class="px-6 py-4 font-semibold">Fecha Monta</th>
                                <th class="px-6 py-4 font-semibold">Parto Est.</th>
                                <th class="px-6 py-4 font-semibold">Parto Real</th>
                                <th class="px-6 py-4 font-semibold">Crías / Arete Cría</th>
                                <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant text-sm text-on-surface bg-surface-container-lowest">
                            @forelse($ciclos as $item)
                            <tr class="hover:bg-surface-container-low/50 transition-colors group">
                                <td class="px-6 py-4 font-mono-data text-primary font-bold">#{{ $item->id_ciclo }}</td>
                                <td class="px-6 py-4 font-medium">
                                    @if($item->madre)
                                        <span class="text-primary font-bold font-mono-data">#{{ $item->madre->arete }}</span>
                                        @if($item->madre->nombre) <span class="text-xs text-on-surface-variant">({{ $item->madre->nombre }})</span> @endif
                                    @else
                                        <span class="text-on-surface-variant">Madre #{{ $item->id_madre }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->tipo_monta === 'natural')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-secondary-container text-on-secondary-container text-xs font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">pets</span> Natural
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-primary/10 text-primary text-xs font-semibold border border-primary/20">
                                            <span class="material-symbols-outlined text-[14px]">science</span> Inseminación
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-mono-data">
                                    {{ \Carbon\Carbon::parse($item->fecha_monta)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 font-mono-data text-tertiary font-semibold">
                                    {{ $item->fecha_parto_estimada ? \Carbon\Carbon::parse($item->fecha_parto_estimada)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 font-mono-data text-primary font-semibold">
                                    {{ $item->fecha_parto_real ? \Carbon\Carbon::parse($item->fecha_parto_real)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold">{{ $item->numero_crias ?? 0 }}</span>
                                    @if($item->cria)
                                        <span class="text-xs text-on-surface-variant ml-1 font-mono-data">(Arete: #{{ $item->cria->arete }})</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1 opacity-90 group-hover:opacity-100 transition-opacity">
                                        <button onclick='abrirDrawerDetalleCiclo(@json($item))' class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded transition-colors" title="Ver Detalle">
                                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                                        </button>
                                        <button onclick='abrirModalEditarCiclo(@json($item))' class="p-1.5 text-on-surface-variant hover:text-secondary-fixed-dim hover:bg-secondary-container/50 rounded transition-colors" title="Editar">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>
                                        <button onclick="abrirModalEliminarCiclo({{ $item->id_ciclo }})" class="p-1.5 text-on-surface-variant hover:text-error hover:bg-error-container/50 rounded transition-colors" title="Eliminar">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-outline">favorite</span>
                                    <p class="font-medium text-base">No hay registros de ciclos reproductivos.</p>
                                    <p class="text-xs mt-1">Haz clic en "+ Registrar Ciclo Reproductivo" para agregar el primero.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Stats -->
                <div class="px-6 py-4 border-t border-outline-variant bg-surface-container-lowest flex items-center justify-between text-xs text-on-surface-variant">
                    <span>Mostrando {{ count($ciclos) }} ciclos registrados</span>
                    <span>Sistema Ganadero v1.0</span>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- ========================================================= -->
<!-- MODAL: REGISTRAR / EDITAR CICLO REPRODUCTIVO               -->
<!-- ========================================================= -->
<div id="modal-ciclo" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6 modal-backdrop">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-2xl shadow-ambient-lvl2 flex flex-col max-h-[90vh] overflow-hidden border border-outline-variant modal-content">
        <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant bg-surface">
            <h2 id="modal-ciclo-titulo" class="text-lg font-semibold text-on-surface">Registrar Ciclo Reproductivo</h2>
            <button onclick="cerrarModalCiclo()" class="text-on-surface-variant hover:text-on-surface transition-colors rounded-full p-1 hover:bg-surface-container-highest">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="form-ciclo" method="POST" action="{{ route('ciclo-reproductivo.store') }}" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <input type="hidden" id="ciclo-form-method" name="_method" value="POST">
            
            <div class="px-6 py-6 overflow-y-auto space-y-4 flex-1">
                <!-- Seleccionar Madre -->
                <div>
                    <label for="select-madre" class="block text-xs font-semibold text-on-surface mb-1.5">Vaca / Madre (Arete - Nombre) *</label>
                    <select id="select-madre" name="id_madre" required class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                        <option value="" disabled selected>Seleccionar Hembra</option>
                        @foreach($hembras as $hembra)
                            <option value="{{ $hembra->id_animal }}">Arete #{{ $hembra->arete }} {{ $hembra->nombre ? ' - '.$hembra->nombre : '' }} ({{ $hembra->raza }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tipo Monta -->
                    <div>
                        <label for="select-tipo-monta" class="block text-xs font-semibold text-on-surface mb-1.5">Tipo de Monta *</label>
                        <select id="select-tipo-monta" name="tipo_monta" required class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                            <option value="natural">Monta Natural</option>
                            <option value="inseminacion">Inseminación Artificial</option>
                        </select>
                    </div>

                    <!-- Fecha Monta -->
                    <div>
                        <label for="input-fecha-monta" class="block text-xs font-semibold text-on-surface mb-1.5">Fecha de Monta *</label>
                        <input type="date" id="input-fecha-monta" name="fecha_monta" required value="{{ date('Y-m-d') }}"
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"/>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Fecha Parto Estimada -->
                    <div>
                        <label for="input-fecha-parto-est" class="block text-xs font-semibold text-on-surface mb-1.5">Fecha Parto Estimada</label>
                        <input type="date" id="input-fecha-parto-est" name="fecha_parto_estimada" 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"/>
                    </div>

                    <!-- Fecha Parto Real -->
                    <div>
                        <label for="input-fecha-parto-real" class="block text-xs font-semibold text-on-surface mb-1.5">Fecha Parto Real</label>
                        <input type="date" id="input-fecha-parto-real" name="fecha_parto_real" 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"/>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Número Crías -->
                    <div>
                        <label for="input-numero-crias" class="block text-xs font-semibold text-on-surface mb-1.5">Número de Crías</label>
                        <input type="number" id="input-numero-crias" name="numero_crias" min="0" placeholder="Ej: 1" 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/60"/>
                    </div>

                    <!-- Fecha Destete -->
                    <div>
                        <label for="input-fecha-destete" class="block text-xs font-semibold text-on-surface mb-1.5">Fecha de Destete</label>
                        <input type="date" id="input-fecha-destete" name="fecha_destete" 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"/>
                    </div>
                </div>

                <!-- Seleccionar Cría -->
                <div>
                    <label for="select-cria" class="block text-xs font-semibold text-on-surface mb-1.5">Cría Nacida (Opcional - Seleccionar Animal)</label>
                    <select id="select-cria" name="id_cria" class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                        <option value="">Ninguna / Sin Asignar</option>
                        @foreach($animales as $cria)
                            <option value="{{ $cria->id_animal }}">Arete #{{ $cria->arete }} {{ $cria->nombre ? ' - '.$cria->nombre : '' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-outline-variant bg-surface">
                <button type="button" onclick="cerrarModalCiclo()" class="px-4 py-2.5 rounded-md border border-outline-variant text-xs font-semibold text-on-surface hover:bg-surface-container-highest transition-colors">
                    Cancelar
                </button>
                <button type="submit" id="btn-guardar-ciclo" class="px-6 py-2.5 rounded-md bg-primary text-on-primary text-xs font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                    Guardar Registro
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL ELIMINAR -->
<div id="modal-eliminar-ciclo" class="fixed inset-0 z-50 hidden items-center justify-center p-4 modal-backdrop">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-md p-6 shadow-ambient-lvl2 border border-outline-variant text-center space-y-4 modal-content">
        <div class="w-14 h-14 rounded-full bg-error-container/30 border border-error/20 text-error flex items-center justify-center mx-auto">
            <span class="material-symbols-outlined text-2xl">warning</span>
        </div>
        <div>
            <h3 class="text-lg font-bold text-on-surface">¿Eliminar ciclo reproductivo?</h3>
            <p class="text-xs text-on-surface-variant mt-1">Está a punto de eliminar el registro de ciclo seleccionado.</p>
        </div>
        <form id="form-eliminar-ciclo" method="POST" action="" class="flex items-center justify-center gap-3 pt-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="cerrarModalEliminarCiclo()" class="w-full h-10 px-4 rounded-md border border-outline-variant text-xs font-semibold text-on-surface hover:bg-surface-container-highest transition-colors">
                Cancelar
            </button>
            <button type="submit" class="w-full h-10 px-5 rounded-md bg-error text-on-error text-xs font-semibold hover:bg-error/90 transition-colors shadow-sm">
                Sí, Eliminar
            </button>
        </form>
    </div>
</div>

<!-- DRAWER DETALLE -->
<div id="drawer-overlay-ciclo" class="fixed inset-0 modal-backdrop z-40 hidden" onclick="cerrarDrawerDetalleCiclo()"></div>
<aside id="drawer-detalle-ciclo" class="fixed top-0 right-0 h-full w-full max-w-md bg-surface-container-lowest border-l border-outline-variant z-50 shadow-ambient-lvl2 transform translate-x-full transition-transform duration-300 flex flex-col">
    <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant bg-surface">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">diversity_1</span>
            <h3 class="text-base font-bold text-on-surface">Detalle de Ciclo Reproductivo</h3>
        </div>
        <button onclick="cerrarDrawerDetalleCiclo()" class="text-on-surface-variant hover:text-on-surface p-1 rounded-full hover:bg-surface-container-highest">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <div class="p-6 space-y-6 flex-1 overflow-y-auto">
        <div class="space-y-3">
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Madre</span>
                <span id="detail-ciclo-madre" class="font-bold text-primary">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Tipo Monta</span>
                <span id="detail-ciclo-tipo" class="font-semibold text-on-surface">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Fecha Monta</span>
                <span id="detail-ciclo-fecha-monta" class="font-mono-data text-on-surface">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Parto Estimado</span>
                <span id="detail-ciclo-parto-est" class="font-mono-data text-tertiary font-semibold">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Parto Real</span>
                <span id="detail-ciclo-parto-real" class="font-mono-data text-primary font-semibold">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Número Crías</span>
                <span id="detail-ciclo-crias" class="font-semibold text-on-surface">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Cría Asignada</span>
                <span id="detail-ciclo-cria-asig" class="font-bold text-primary">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Fecha Destete</span>
                <span id="detail-ciclo-destete" class="font-mono-data text-on-surface">-</span>
            </div>
        </div>
    </div>

    <div class="p-6 border-t border-outline-variant bg-surface-container-low flex gap-3">
        <button id="btn-edit-ciclo-from-drawer" class="flex-1 py-2.5 bg-primary text-on-primary rounded-md text-xs font-semibold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 shadow-sm">
            <span class="material-symbols-outlined text-sm">edit</span> Editar Registro
        </button>
    </div>
</aside>

@if(session('success'))
<div id="modal-exito" class="fixed inset-0 z-50 flex items-center justify-center p-4 modal-backdrop">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-sm p-6 shadow-ambient-lvl2 border border-outline-variant text-center space-y-4 modal-content">
        <div class="w-14 h-14 rounded-full bg-primary/20 text-primary border border-primary/30 flex items-center justify-center mx-auto">
            <span class="material-symbols-outlined text-3xl">check_circle</span>
        </div>
        <div>
            <h3 class="text-lg font-bold text-on-surface">{{ session('title', '¡Operación Exitosa!') }}</h3>
            <p class="text-xs text-on-surface-variant mt-1">{{ session('success') }}</p>
        </div>
        <button onclick="document.getElementById('modal-exito').remove()" class="w-full py-2.5 rounded-md bg-primary text-on-primary text-xs font-semibold hover:bg-primary/90 transition-colors shadow-sm">
            Aceptar
        </button>
    </div>
</div>
@endif

<!-- DRAWER DETALLE -->
<div id="drawer-overlay-ciclo" class="fixed inset-0 modal-backdrop z-40 hidden" onclick="cerrarDrawerDetalleCiclo()"></div>
<aside id="drawer-detalle-ciclo" class="fixed top-0 right-0 h-full w-full max-w-md bg-surface-container-lowest border-l border-outline-variant z-50 shadow-ambient-lvl2 transform translate-x-full transition-transform duration-300 flex flex-col">
    <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant bg-surface">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">diversity_1</span>
            <h3 class="text-base font-bold text-on-surface">Detalle de Ciclo Reproductivo</h3>
        </div>
        <button onclick="cerrarDrawerDetalleCiclo()" class="text-on-surface-variant hover:text-on-surface p-1 rounded-full hover:bg-surface-container-highest">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <div class="p-6 space-y-6 flex-1 overflow-y-auto">
        <div class="space-y-3">
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Madre</span>
                <span id="detail-ciclo-madre" class="font-bold text-primary">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Tipo Monta</span>
                <span id="detail-ciclo-tipo" class="font-semibold text-on-surface">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Fecha Monta</span>
                <span id="detail-ciclo-fecha-monta" class="font-mono-data text-on-surface">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Parto Estimado</span>
                <span id="detail-ciclo-parto-est" class="font-mono-data text-tertiary font-semibold">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Parto Real</span>
                <span id="detail-ciclo-parto-real" class="font-mono-data text-primary font-semibold">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Número Crías</span>
                <span id="detail-ciclo-crias" class="font-semibold text-on-surface">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Cría Asignada</span>
                <span id="detail-ciclo-cria-asig" class="font-bold text-primary">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Fecha Destete</span>
                <span id="detail-ciclo-destete" class="font-mono-data text-on-surface">-</span>
            </div>
        </div>
    </div>

    <div class="p-6 border-t border-outline-variant bg-surface-container-low flex gap-3">
        <button id="btn-edit-ciclo-from-drawer" class="flex-1 py-2.5 bg-primary text-on-primary rounded-md text-xs font-semibold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 shadow-sm">
            <span class="material-symbols-outlined text-sm">edit</span> Editar Registro
        </button>
    </div>
</aside>

@if(session('success'))
<div id="modal-exito" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-on-surface/40 backdrop-blur-overlay">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-sm p-6 shadow-ambient-lvl2 border border-outline-variant text-center space-y-4">
        <div class="w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center mx-auto">
            <span class="material-symbols-outlined text-3xl">check_circle</span>
        </div>
        <div>
            <h3 class="text-lg font-bold text-on-surface">{{ session('title', '¡Operación Exitosa!') }}</h3>
            <p class="text-xs text-on-surface-variant mt-1">{{ session('success') }}</p>
        </div>
        <button onclick="document.getElementById('modal-exito').remove()" class="w-full py-2.5 rounded-md bg-primary text-on-primary text-xs font-semibold hover:bg-primary/90 transition-colors shadow-sm">
            Aceptar
        </button>
    </div>
</div>
@endif

<script>
    const cicloBaseUrl = "{{ url('ciclo-reproductivo') }}";

    function abrirModalCrearCiclo() {
        document.getElementById('modal-ciclo-titulo').innerText = 'Registrar Ciclo Reproductivo';
        document.getElementById('form-ciclo').action = cicloBaseUrl;
        document.getElementById('ciclo-form-method').value = 'POST';
        document.getElementById('form-ciclo').reset();
        document.getElementById('btn-guardar-ciclo').innerText = 'Guardar Registro';

        document.getElementById('modal-ciclo').classList.remove('hidden');
        document.getElementById('modal-ciclo').classList.add('flex');
    }

    function abrirModalEditarCiclo(item) {
        document.getElementById('modal-ciclo-titulo').innerText = `Editar Ciclo Reproductivo #${item.id_ciclo}`;
        document.getElementById('form-ciclo').action = `${cicloBaseUrl}/${item.id_ciclo}`;
        document.getElementById('ciclo-form-method').value = 'PUT';

        document.getElementById('select-madre').value = item.id_madre || '';
        document.getElementById('select-tipo-monta').value = item.tipo_monta || 'natural';
        document.getElementById('input-fecha-monta').value = item.fecha_monta || '';
        document.getElementById('input-fecha-parto-est').value = item.fecha_parto_estimada || '';
        document.getElementById('input-fecha-parto-real').value = item.fecha_parto_real || '';
        document.getElementById('input-numero-crias').value = item.numero_crias !== null ? item.numero_crias : '';
        document.getElementById('select-cria').value = item.id_cria || '';
        document.getElementById('input-fecha-destete').value = item.fecha_destete || '';

        document.getElementById('btn-guardar-ciclo').innerText = 'Actualizar Registro';

        document.getElementById('modal-ciclo').classList.remove('hidden');
        document.getElementById('modal-ciclo').classList.add('flex');
    }

    function cerrarModalCiclo() {
        document.getElementById('modal-ciclo').classList.add('hidden');
        document.getElementById('modal-ciclo').classList.remove('flex');
    }

    function abrirModalEliminarCiclo(id) {
        document.getElementById('form-eliminar-ciclo').action = `${cicloBaseUrl}/${id}`;
        document.getElementById('modal-eliminar-ciclo').classList.remove('hidden');
        document.getElementById('modal-eliminar-ciclo').classList.add('flex');
    }

    function cerrarModalEliminarCiclo() {
        document.getElementById('modal-eliminar-ciclo').classList.add('hidden');
        document.getElementById('modal-eliminar-ciclo').classList.remove('flex');
    }

    function abrirDrawerDetalleCiclo(item) {
        document.getElementById('detail-ciclo-madre').innerText = item.madre ? `#${item.madre.arete} ${item.madre.nombre ? '- '+item.madre.nombre : ''}` : `#${item.id_madre}`;
        document.getElementById('detail-ciclo-tipo').innerText = item.tipo_monta || '-';
        document.getElementById('detail-ciclo-fecha-monta').innerText = item.fecha_monta || '-';
        document.getElementById('detail-ciclo-parto-est').innerText = item.fecha_parto_estimada || '-';
        document.getElementById('detail-ciclo-parto-real').innerText = item.fecha_parto_real || '-';
        document.getElementById('detail-ciclo-crias').innerText = item.numero_crias ?? '0';
        document.getElementById('detail-ciclo-cria-asig').innerText = item.cria ? `#${item.cria.arete}` : 'Ninguna';
        document.getElementById('detail-ciclo-destete').innerText = item.fecha_destete || '-';

        document.getElementById('btn-edit-ciclo-from-drawer').onclick = function() {
            cerrarDrawerDetalleCiclo();
            abrirModalEditarCiclo(item);
        };

        document.getElementById('drawer-overlay-ciclo').classList.remove('hidden');
        document.getElementById('drawer-detalle-ciclo').classList.remove('translate-x-full');
    }

    function cerrarDrawerDetalleCiclo() {
        document.getElementById('drawer-overlay-ciclo').classList.add('hidden');
        document.getElementById('drawer-detalle-ciclo').classList.add('translate-x-full');
    }

    document.getElementById('top-search-input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            window.location.href = `{{ route('ciclo-reproductivo.index') }}?buscar=${encodeURIComponent(this.value)}`;
        }
    });

</script>
@endsection
