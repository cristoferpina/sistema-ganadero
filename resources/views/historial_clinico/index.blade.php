@extends('layouts.app')

@section('title', 'Historial Clínico - Sistema Ganadero')

@section('content')
<div class="h-screen w-screen overflow-hidden flex flex-col bg-background">
    <!-- Top Navigation Bar Shell -->
    <nav class="fixed top-0 left-0 w-full flex justify-between items-center px-6 h-16 bg-surface border-b border-outline-variant shadow-sm z-30">
        <div class="flex items-center gap-4">
            <button class="md:hidden p-2 rounded hover:bg-surface-container-highest transition-colors" onclick="toggleSidebar()" aria-label="Abrir menú">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <span class="font-bold text-xl text-primary flex items-center gap-2">
                <span class="material-symbols-outlined fill text-primary">pets</span>
                Sistema Ganadero
            </span>
        </div>
        <div class="flex-1 flex justify-end px-8">
            <div class="relative w-64 md:w-80">
                <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-on-surface-variant">search</span>
                <input id="top-search-input" type="text" placeholder="Buscar por producto o arete del animal..." 
                       class="w-full pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-system text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-on-surface placeholder:text-on-surface-variant"/>
            </div>
        </div>
    </nav>

    <!-- Side Navigation Shell -->
    <aside id="sidebar" class="fixed left-0 top-0 h-full flex flex-col py-6 border-r border-outline-variant bg-surface-container w-64 pt-20 z-20">
        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('ganado.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-on-surface-variant hover:bg-surface-container-highest transition-all text-xs">
                <span class="material-symbols-outlined">pets</span> Ganado
            </a>
            <a href="{{ route('historial-clinico.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-primary font-semibold border-r-4 border-primary bg-surface-container-high text-xs">
                <span class="material-symbols-outlined fill">medical_services</span> Historial Clínico
            </a>
            <a href="{{ route('ciclo-reproductivo.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-on-surface-variant hover:bg-surface-container-highest transition-all text-xs">
                <span class="material-symbols-outlined">diversity_1</span> Ciclos Reproductivos
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
                    <h1 class="text-2xl font-bold text-primary">Historial Clínico Sanitario</h1>
                    <p class="text-sm text-on-surface-variant mt-1">Registro de vacunas, desparasitaciones y tratamientos médicos.</p>
                </div>
                <button onclick="abrirModalCrearHistorial()" class="bg-primary text-on-primary text-xs font-semibold px-5 py-2.5 rounded-system hover:bg-primary/90 transition-colors flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-sm">add_medical</span>
                    Registrar Evento Clínico
                </button>
            </header>

            <!-- CRUD Module Container -->
            <div class="bg-surface-container-lowest rounded-system border border-outline-variant shadow-ambient-lvl1 overflow-hidden">
                <!-- Top Action Bar & Filters -->
                <form method="GET" action="{{ route('historial-clinico.index') }}" class="p-4 sm:p-6 border-b border-outline-variant bg-surface-container-lowest flex flex-col md:flex-row gap-3 sm:gap-4 items-stretch md:items-center justify-between">
                    <div class="relative w-full md:w-[260px] lg:w-[320px]">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por Producto o Arete..." 
                               class="w-full pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-system text-xs sm:text-sm text-on-surface placeholder:text-on-surface-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"/>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 sm:gap-3 w-full md:w-auto">
                        <div class="relative flex-1 sm:flex-none">
                            <select name="tipo_evento" onchange="this.form.submit()" class="w-full sm:w-auto appearance-none bg-surface-container-low border border-outline-variant rounded-system pl-3 sm:pl-4 pr-9 py-2 text-xs sm:text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary min-w-[150px]">
                                <option value="">Todos los Eventos</option>
                                <option value="vacuna" {{ request('tipo_evento') == 'vacuna' ? 'selected' : '' }}>Vacuna</option>
                                <option value="desparasitacion" {{ request('tipo_evento') == 'desparasitacion' ? 'selected' : '' }}>Desparasitación</option>
                                <option value="tratamiento" {{ request('tipo_evento') == 'tratamiento' ? 'selected' : '' }}>Tratamiento</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">arrow_drop_down</span>
                        </div>

                        @if(request()->hasAny(['buscar', 'tipo_evento']))
                        <a href="{{ route('historial-clinico.index') }}" class="p-2 text-on-surface-variant hover:text-error transition-colors flex items-center" title="Limpiar filtros">
                            <span class="material-symbols-outlined">filter_alt_off</span>
                        </a>
                        @endif
                    </div>
                </form>

                <!-- Data Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse min-w-[950px]">
                        <thead class="bg-surface-container-low text-xs text-on-surface-variant uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-semibold w-16">ID</th>
                                <th class="px-6 py-4 font-semibold">Animal (Arete)</th>
                                <th class="px-6 py-4 font-semibold">Tipo Evento</th>
                                <th class="px-6 py-4 font-semibold">Producto</th>
                                <th class="px-6 py-4 font-semibold">Dosis</th>
                                <th class="px-6 py-4 font-semibold">Aplicación</th>
                                <th class="px-6 py-4 font-semibold">Próx. Dosis</th>
                                <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant text-sm text-on-surface bg-surface-container-lowest">
                            @forelse($historiales as $item)
                            <tr class="hover:bg-surface-container-low/50 transition-colors group">
                                <td class="px-6 py-4 font-mono-data text-primary font-bold">#{{ $item->id_historial }}</td>
                                <td class="px-6 py-4 font-medium">
                                    @if($item->animal)
                                        <span class="text-primary font-bold font-mono-data">#{{ $item->animal->arete }}</span>
                                        @if($item->animal->nombre) <span class="text-xs text-on-surface-variant">({{ $item->animal->nombre }})</span> @endif
                                    @else
                                        <span class="text-on-surface-variant">Animal #{{ $item->id_animal }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->tipo_evento === 'vacuna')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-primary/10 text-primary text-xs font-semibold border border-primary/20">
                                            <span class="material-symbols-outlined text-[14px]">vaccines</span> Vacuna
                                        </span>
                                    @elseif($item->tipo_evento === 'desparasitacion')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-secondary-container text-on-secondary-container text-xs font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">bug_report</span> Desparasitación
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-tertiary-container text-on-tertiary-container text-xs font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">medication</span> Tratamiento
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-semibold">{{ $item->nombre_producto }}</td>
                                <td class="px-6 py-4 font-mono-data text-on-surface-variant">{{ $item->dosis ?? '-' }}</td>
                                <td class="px-6 py-4 font-mono-data">
                                    {{ \Carbon\Carbon::parse($item->fecha_aplicacion)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 font-mono-data text-on-surface-variant">
                                    {{ $item->fecha_proxima_aplicacion ? \Carbon\Carbon::parse($item->fecha_proxima_aplicacion)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1 opacity-90 group-hover:opacity-100 transition-opacity">
                                        <button onclick='abrirDrawerDetalleHistorial(@json($item))' class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded transition-colors" title="Ver Detalle">
                                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                                        </button>
                                        <button onclick='abrirModalEditarHistorial(@json($item))' class="p-1.5 text-on-surface-variant hover:text-secondary-fixed-dim hover:bg-secondary-container/50 rounded transition-colors" title="Editar">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>
                                        <button onclick="abrirModalEliminarHistorial({{ $item->id_historial }}, '{{ addslashes($item->nombre_producto) }}')" class="p-1.5 text-on-surface-variant hover:text-error hover:bg-error-container/50 rounded transition-colors" title="Eliminar">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-outline">health_metrics</span>
                                    <p class="font-medium text-base">No hay registros de historial clínico.</p>
                                    <p class="text-xs mt-1">Haz clic en "+ Registrar Evento Clínico" para agregar el primero.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Stats -->
                <div class="px-6 py-4 border-t border-outline-variant bg-surface-container-lowest flex items-center justify-between text-xs text-on-surface-variant">
                    <span>Mostrando {{ count($historiales) }} registros clínicos</span>
                    <span>Sistema Ganadero v1.0</span>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- ========================================================= -->
<!-- MODAL: REGISTRAR / EDITAR HISTORIAL CLÍNICO               -->
<!-- ========================================================= -->
<div id="modal-historial" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6 modal-backdrop">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-2xl shadow-ambient-lvl2 flex flex-col max-h-[90vh] overflow-hidden border border-outline-variant modal-content">
        <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant bg-surface">
            <h2 id="modal-historial-titulo" class="text-lg font-semibold text-on-surface">Registrar Evento Clínico</h2>
            <button onclick="cerrarModalHistorial()" class="text-on-surface-variant hover:text-on-surface transition-colors rounded-full p-1 hover:bg-surface-container-highest">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="form-historial" method="POST" action="{{ route('historial-clinico.store') }}" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <input type="hidden" id="historial-form-method" name="_method" value="POST">
            
            <div class="px-6 py-6 overflow-y-auto space-y-4 flex-1">
                <!-- Seleccionar Animal -->
                <div>
                    <label for="select-animal" class="block text-xs font-semibold text-on-surface mb-1.5">Animal (Arete - Nombre) *</label>
                    <select id="select-animal" name="id_animal" required class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                        <option value="" disabled selected>Seleccionar Animal</option>
                        @foreach($animales as $anim)
                            <option value="{{ $anim->id_animal }}">Arete #{{ $anim->arete }} {{ $anim->nombre ? ' - '.$anim->nombre : '' }} ({{ $anim->raza }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tipo Evento -->
                    <div>
                        <label for="select-tipo-evento" class="block text-xs font-semibold text-on-surface mb-1.5">Tipo de Evento *</label>
                        <select id="select-tipo-evento" name="tipo_evento" required class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                            <option value="vacuna">Vacuna</option>
                            <option value="desparasitacion">Desparasitación</option>
                            <option value="tratamiento">Tratamiento</option>
                        </select>
                    </div>

                    <!-- Dosis -->
                    <div>
                        <label for="input-dosis" class="block text-xs font-semibold text-on-surface mb-1.5">Dosis</label>
                        <input type="text" id="input-dosis" name="dosis" placeholder="Ej: 5 ml, 1 pastilla" 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/60"/>
                    </div>
                </div>

                <!-- Nombre Producto -->
                <div>
                    <label for="input-nombre-producto" class="block text-xs font-semibold text-on-surface mb-1.5">Nombre del Producto / Medicamento *</label>
                    <input type="text" id="input-nombre-producto" name="nombre_producto" required placeholder="Ej: Ivermectina 1%, Aftosa" 
                           class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/60"/>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Fecha Aplicación -->
                    <div>
                        <label for="input-fecha-aplicacion" class="block text-xs font-semibold text-on-surface mb-1.5">Fecha de Aplicación *</label>
                        <input type="date" id="input-fecha-aplicacion" name="fecha_aplicacion" required value="{{ date('Y-m-d') }}"
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"/>
                    </div>

                    <!-- Fecha Próxima Aplicación -->
                    <div>
                        <label for="input-fecha-proxima" class="block text-xs font-semibold text-on-surface mb-1.5">Próxima Aplicación</label>
                        <input type="date" id="input-fecha-proxima" name="fecha_proxima_aplicacion" 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"/>
                    </div>
                </div>

                <!-- Usuario Responsable -->
                <div>
                    <label for="select-usuario-resp" class="block text-xs font-semibold text-on-surface mb-1.5">Usuario Responsable</label>
                    <select id="select-usuario-resp" name="id_usuario" class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                        @foreach($usuarios as $usr)
                            <option value="{{ $usr->id_usuario }}">{{ $usr->nombre_completo }} (@ {{ $usr->nombre_usuario }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-outline-variant bg-surface">
                <button type="button" onclick="cerrarModalHistorial()" class="px-4 py-2.5 rounded-md border border-outline-variant text-xs font-semibold text-on-surface hover:bg-surface-container-highest transition-colors">
                    Cancelar
                </button>
                <button type="submit" id="btn-guardar-historial" class="px-6 py-2.5 rounded-md bg-primary text-on-primary text-xs font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                    Guardar Registro
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL ELIMINAR -->
<div id="modal-eliminar-historial" class="fixed inset-0 z-50 hidden items-center justify-center p-4 modal-backdrop">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-md p-6 shadow-ambient-lvl2 border border-outline-variant text-center space-y-4 modal-content">
        <div class="w-14 h-14 rounded-full bg-error-container/30 border border-error/20 text-error flex items-center justify-center mx-auto">
            <span class="material-symbols-outlined text-2xl">warning</span>
        </div>
        <div>
            <h3 class="text-lg font-bold text-on-surface">¿Eliminar registro clínico?</h3>
            <p class="text-xs text-on-surface-variant mt-1">Se eliminará el evento de <span id="eliminar-historial-prod" class="font-bold text-primary"></span>.</p>
        </div>
        <form id="form-eliminar-historial" method="POST" action="" class="flex items-center justify-center gap-3 pt-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="cerrarModalEliminarHistorial()" class="w-full h-10 px-4 rounded-md border border-outline-variant text-xs font-semibold text-on-surface hover:bg-surface-container-highest transition-colors">
                Cancelar
            </button>
            <button type="submit" class="w-full h-10 px-5 rounded-md bg-error text-on-error text-xs font-semibold hover:bg-error/90 transition-colors shadow-sm">
                Sí, Eliminar
            </button>
        </form>
    </div>
</div>

<!-- DRAWER DETALLE -->
<div id="drawer-overlay-historial" class="fixed inset-0 modal-backdrop z-40 hidden" onclick="cerrarDrawerDetalleHistorial()"></div>
<aside id="drawer-detalle-historial" class="fixed top-0 right-0 h-full w-full max-w-md bg-surface-container-lowest border-l border-outline-variant z-50 shadow-ambient-lvl2 transform translate-x-full transition-transform duration-300 flex flex-col">
    <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant bg-surface">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">medical_services</span>
            <h3 class="text-base font-bold text-on-surface">Detalle de Evento Clínico</h3>
        </div>
        <button onclick="cerrarDrawerDetalleHistorial()" class="text-on-surface-variant hover:text-on-surface p-1 rounded-full hover:bg-surface-container-highest">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <div class="p-6 space-y-6 flex-1 overflow-y-auto">
        <div class="flex items-center gap-4 p-4 rounded-system bg-surface-container-low border border-outline-variant">
            <div class="w-12 h-12 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-base">
                <span class="material-symbols-outlined">vaccines</span>
            </div>
            <div>
                <h4 id="detail-hist-prod" class="font-bold text-base text-on-surface">Producto</h4>
                <p id="detail-hist-tipo" class="text-xs text-primary font-semibold uppercase">Vacuna</p>
            </div>
        </div>

        <div class="space-y-3">
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Animal</span>
                <span id="detail-hist-animal" class="font-bold text-primary">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Dosis</span>
                <span id="detail-hist-dosis" class="font-mono-data text-on-surface">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Fecha Aplicación</span>
                <span id="detail-hist-fecha" class="font-mono-data text-on-surface">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Próxima Aplicación</span>
                <span id="detail-hist-prox" class="font-mono-data text-on-surface">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Registrado Por</span>
                <span id="detail-hist-usuario" class="text-on-surface">-</span>
            </div>
        </div>
    </div>

    <div class="p-6 border-t border-outline-variant bg-surface-container-low flex gap-3">
        <button id="btn-edit-hist-from-drawer" class="flex-1 py-2.5 bg-primary text-on-primary rounded-md text-xs font-semibold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 shadow-sm">
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

<script>
    const histBaseUrl = "{{ url('historial-clinico') }}";

    function abrirModalCrearHistorial() {
        document.getElementById('modal-historial-titulo').innerText = 'Registrar Evento Clínico';
        document.getElementById('form-historial').action = histBaseUrl;
        document.getElementById('historial-form-method').value = 'POST';
        document.getElementById('form-historial').reset();
        document.getElementById('btn-guardar-historial').innerText = 'Guardar Registro';

        document.getElementById('modal-historial').classList.remove('hidden');
        document.getElementById('modal-historial').classList.add('flex');
    }

    function abrirModalEditarHistorial(item) {
        document.getElementById('modal-historial-titulo').innerText = `Editar Evento Clínico #${item.id_historial}`;
        document.getElementById('form-historial').action = `${histBaseUrl}/${item.id_historial}`;
        document.getElementById('historial-form-method').value = 'PUT';

        document.getElementById('select-animal').value = item.id_animal || '';
        document.getElementById('select-tipo-evento').value = item.tipo_evento || 'vacuna';
        document.getElementById('input-nombre-producto').value = item.nombre_producto || '';
        document.getElementById('input-dosis').value = item.dosis || '';
        document.getElementById('input-fecha-aplicacion').value = item.fecha_aplicacion || '';
        document.getElementById('input-fecha-proxima').value = item.fecha_proxima_aplicacion || '';
        document.getElementById('select-usuario-resp').value = item.id_usuario || '';

        document.getElementById('btn-guardar-historial').innerText = 'Actualizar Registro';

        document.getElementById('modal-historial').classList.remove('hidden');
        document.getElementById('modal-historial').classList.add('flex');
    }

    function cerrarModalHistorial() {
        document.getElementById('modal-historial').classList.add('hidden');
        document.getElementById('modal-historial').classList.remove('flex');
    }

    function abrirModalEliminarHistorial(id, prod) {
        document.getElementById('eliminar-historial-prod').innerText = `"${prod}"`;
        document.getElementById('form-eliminar-historial').action = `${histBaseUrl}/${id}`;
        document.getElementById('modal-eliminar-historial').classList.remove('hidden');
        document.getElementById('modal-eliminar-historial').classList.add('flex');
    }

    function cerrarModalEliminarHistorial() {
        document.getElementById('modal-eliminar-historial').classList.add('hidden');
        document.getElementById('modal-eliminar-historial').classList.remove('flex');
    }

    function abrirDrawerDetalleHistorial(item) {
        document.getElementById('detail-hist-prod').innerText = item.nombre_producto || 'Sin Nombre';
        document.getElementById('detail-hist-tipo').innerText = item.tipo_evento || '';
        document.getElementById('detail-hist-animal').innerText = item.animal ? `#${item.animal.arete} ${item.animal.nombre ? '- '+item.animal.nombre : ''}` : `#${item.id_animal}`;
        document.getElementById('detail-hist-dosis').innerText = item.dosis || '-';
        document.getElementById('detail-hist-fecha').innerText = item.fecha_aplicacion || '-';
        document.getElementById('detail-hist-prox').innerText = item.fecha_proxima_aplicacion || '-';
        document.getElementById('detail-hist-usuario').innerText = item.usuario ? item.usuario.nombre_completo : `ID #${item.id_usuario}`;

        document.getElementById('btn-edit-hist-from-drawer').onclick = function() {
            cerrarDrawerDetalleHistorial();
            abrirModalEditarHistorial(item);
        };

        document.getElementById('drawer-overlay-historial').classList.remove('hidden');
        document.getElementById('drawer-detalle-historial').classList.remove('translate-x-full');
    }

    function cerrarDrawerDetalleHistorial() {
        document.getElementById('drawer-overlay-historial').classList.add('hidden');
        document.getElementById('drawer-detalle-historial').classList.add('translate-x-full');
    }

    document.getElementById('top-search-input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            window.location.href = `{{ route('historial-clinico.index') }}?buscar=${encodeURIComponent(this.value)}`;
        }
    });

</script>
@endsection
