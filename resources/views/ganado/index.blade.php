@extends('layouts.app')

@section('title', 'Gestión de Ganado - Sistema Ganadero')

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
                <input id="top-search-input" type="text" placeholder="Buscar animal por arete o nombre..." 
                       class="w-full pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-system text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all text-on-surface placeholder:text-on-surface-variant"/>
            </div>
        </div>
    </nav>

    <!-- Side Navigation Shell -->
    <aside id="sidebar" class="fixed left-0 top-0 h-full flex flex-col py-6 border-r border-outline-variant bg-surface-container w-64 pt-20 z-20 transform -translate-x-full md:translate-x-0 md:static md:translate-x-0 transition-transform">
        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('ganado.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system {{ request()->routeIs('ganado.*') ? 'text-primary font-semibold border-r-4 border-primary bg-surface-container-high' : 'text-on-surface-variant hover:bg-surface-container-highest' }} text-xs transition-all">
                <span class="material-symbols-outlined fill">pets</span> Ganado
            </a>
            <a href="{{ route('historial-clinico.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system {{ request()->routeIs('historial-clinico.*') ? 'text-primary font-semibold border-r-4 border-primary bg-surface-container-high' : 'text-on-surface-variant hover:bg-surface-container-highest' }} text-xs transition-all">
                <span class="material-symbols-outlined">medical_services</span> Historial Clínico
            </a>
            <a href="{{ route('ciclo-reproductivo.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system {{ request()->routeIs('ciclo-reproductivo.*') ? 'text-primary font-semibold border-r-4 border-primary bg-surface-container-high' : 'text-on-surface-variant hover:bg-surface-container-highest' }} text-xs transition-all">
                <span class="material-symbols-outlined">diversity_1</span> Ciclos Reproductivos
            </a>
            <a href="{{ route('ventas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system {{ request()->routeIs('ventas.*') ? 'text-primary font-semibold border-r-4 border-primary bg-surface-container-high' : 'text-on-surface-variant hover:bg-surface-container-highest' }} text-xs transition-all">
                <span class="material-symbols-outlined">payments</span> Ventas y Bajas
            </a>
            <a href="{{ route('usuarios.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system {{ request()->routeIs('usuarios.*') ? 'text-primary font-semibold border-r-4 border-primary bg-surface-container-high' : 'text-on-surface-variant hover:bg-surface-container-highest' }} text-xs transition-all">
                <span class="material-symbols-outlined">manage_accounts</span> Usuarios
            </a>
        </nav>
        <div class="px-4 mt-auto space-y-1">
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-system text-on-surface-variant text-xs hover:bg-surface-container-highest transition-all">
                <span class="material-symbols-outlined">settings</span> Configuración
            </a>
        </div>
    </aside>

    <main class="ml-64 pt-20 flex-1 bg-background p-8 overflow-y-auto z-10">
        <div class="max-w-[1440px] mx-auto space-y-6">
            <!-- Header Section -->
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-primary">Ganadería</h1>
                    <p class="text-sm text-on-surface-variant mt-1">Gestión y registro del rebaño principal.</p>
                </div>
                <button onclick="abrirModalCrear()" class="bg-primary text-on-primary text-xs font-semibold px-5 py-2.5 rounded-system hover:bg-primary/90 transition-colors flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Registrar Animal
                </button>
            </header>

            <!-- CRUD Module Container -->
            <div class="bg-surface-container-lowest rounded-system border border-outline-variant shadow-ambient-lvl1 overflow-hidden">
                <!-- Top Action Bar & Filters -->
                <form method="GET" action="{{ route('ganado.index') }}" class="p-4 sm:p-6 border-b border-outline-variant bg-surface-container-lowest flex flex-col md:flex-row gap-3 sm:gap-4 items-stretch md:items-center justify-between">
                    <!-- Search -->
                    <div class="relative w-full md:w-[260px] lg:w-[320px]">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por Arete o Nombre..." 
                               class="w-full pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-system text-xs sm:text-sm text-on-surface placeholder:text-on-surface-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"/>
                    </div>
                    
                    <!-- Filters -->
                    <div class="flex flex-wrap gap-2 sm:gap-3 w-full md:w-auto">
                        <!-- Categoría -->
                        <div class="relative flex-1 sm:flex-none">
                            <select name="categoria" onchange="this.form.submit()" class="w-full sm:w-auto appearance-none bg-surface-container-low border border-outline-variant rounded-system pl-3 sm:pl-4 pr-9 py-2 text-xs sm:text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary min-w-[130px]">
                                <option value="">Todas las Categorías</option>
                                <option value="Ternero" {{ request('categoria') == 'Ternero' ? 'selected' : '' }}>Ternero</option>
                                <option value="Novillo" {{ request('categoria') == 'Novillo' ? 'selected' : '' }}>Novillo</option>
                                <option value="Vaca" {{ request('categoria') == 'Vaca' ? 'selected' : '' }}>Vaca</option>
                                <option value="Toro" {{ request('categoria') == 'Toro' ? 'selected' : '' }}>Toro</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">arrow_drop_down</span>
                        </div>

                        <!-- Estatus -->
                        <div class="relative flex-1 sm:flex-none">
                            <select name="estatus" onchange="this.form.submit()" class="w-full sm:w-auto appearance-none bg-surface-container-low border border-outline-variant rounded-system pl-3 sm:pl-4 pr-9 py-2 text-xs sm:text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary min-w-[130px]">
                                <option value="">Todos los Estatus</option>
                                <option value="Activo" {{ request('estatus') == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="En Cuarentena" {{ request('estatus') == 'En Cuarentena' ? 'selected' : '' }}>En Cuarentena</option>
                                <option value="Vendido" {{ request('estatus') == 'Vendido' ? 'selected' : '' }}>Vendido</option>
                                <option value="Fallecido" {{ request('estatus') == 'Fallecido' ? 'selected' : '' }}>Fallecido</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">arrow_drop_down</span>
                        </div>

                        <!-- Raza -->
                        <div class="relative flex-1 sm:flex-none">
                            <select name="raza" onchange="this.form.submit()" class="w-full sm:w-auto appearance-none bg-surface-container-low border border-outline-variant rounded-system pl-3 sm:pl-4 pr-9 py-2 text-xs sm:text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary min-w-[130px]">
                                <option value="">Todas las Razas</option>
                                <option value="Angus" {{ request('raza') == 'Angus' ? 'selected' : '' }}>Angus</option>
                                <option value="Hereford" {{ request('raza') == 'Hereford' ? 'selected' : '' }}>Hereford</option>
                                <option value="Brahman" {{ request('raza') == 'Brahman' ? 'selected' : '' }}>Brahman</option>
                                <option value="Holstein" {{ request('raza') == 'Holstein' ? 'selected' : '' }}>Holstein</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">arrow_drop_down</span>
                        </div>

                        @if(request()->hasAny(['buscar', 'categoria', 'estatus', 'raza']))
                        <a href="{{ route('ganado.index') }}" class="p-2 text-on-surface-variant hover:text-error transition-colors flex items-center" title="Limpiar filtros">
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
                                <th class="px-6 py-4 font-semibold w-12">
                                    <input type="checkbox" class="rounded border-outline-variant text-primary focus:ring-primary cursor-pointer w-4 h-4"/>
                                </th>
                                <th class="px-6 py-4 font-semibold">Arete</th>
                                <th class="px-6 py-4 font-semibold">Nombre</th>
                                <th class="px-6 py-4 font-semibold">Raza</th>
                                <th class="px-6 py-4 font-semibold">Sexo</th>
                                <th class="px-6 py-4 font-semibold">Nacimiento</th>
                                <th class="px-6 py-4 font-semibold">Peso</th>
                                <th class="px-6 py-4 font-semibold">Categoría</th>
                                <th class="px-6 py-4 font-semibold">Estatus</th>
                                <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant text-sm text-on-surface bg-surface-container-lowest">
                            @forelse($ganados as $item)
                            <tr class="hover:bg-surface-container-low/50 transition-colors group">
                                <td class="px-6 py-4">
                                    <input type="checkbox" class="rounded border-outline-variant text-primary focus:ring-primary cursor-pointer w-4 h-4"/>
                                </td>
                                <td class="px-6 py-4 font-mono-data text-primary font-bold">#{{ $item->arete }}</td>
                                <td class="px-6 py-4 font-medium">{{ $item->nombre ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->raza }}</td>
                                <td class="px-6 py-4 flex items-center gap-1">
                                    @if($item->sexo === 'Macho')
                                        <span class="material-symbols-outlined text-[18px] text-secondary">male</span> Macho
                                    @else
                                        <span class="material-symbols-outlined text-[18px] text-tertiary-container">female</span> Hembra
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-mono-data text-on-surface-variant">
                                    {{ $item->fecha_nacimiento ? \Carbon\Carbon::parse($item->fecha_nacimiento)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 font-mono-data font-medium">{{ number_format($item->peso_actual, 0) }} kg</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded bg-secondary-container text-on-secondary-container text-xs font-semibold">
                                        {{ $item->categoria }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->estatus === 'Activo')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-primary/10 text-primary text-xs font-semibold border border-primary/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Activo
                                        </span>
                                    @elseif($item->estatus === 'En Cuarentena')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-tertiary/10 text-tertiary text-xs font-semibold border border-tertiary/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span> Cuarentena
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-secondary/10 text-secondary text-xs font-semibold border border-secondary/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> {{ $item->estatus }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1 opacity-90 group-hover:opacity-100 transition-opacity">
                                        <button onclick='abrirDrawerDetalle(@json($item))' class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded transition-colors" title="Ver Detalle">
                                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                                        </button>
                                        <button onclick='abrirModalEditar(@json($item))' class="p-1.5 text-on-surface-variant hover:text-secondary-fixed-dim hover:bg-secondary-container/50 rounded transition-colors" title="Editar">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>
                                        <button onclick="abrirModalEliminar({{ $item->id_animal }}, '{{ $item->arete }}')" class="p-1.5 text-on-surface-variant hover:text-error hover:bg-error-container/50 rounded transition-colors" title="Eliminar">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-6 py-12 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-outline">pets</span>
                                    <p class="font-medium text-base">No se encontraron animales registrados.</p>
                                    <p class="text-xs mt-1">Haz clic en "+ Registrar Animal" para añadir el primero.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Stats -->
                <div class="px-6 py-4 border-t border-outline-variant bg-surface-container-lowest flex items-center justify-between text-xs text-on-surface-variant">
                    <span>Mostrando {{ count($ganados) }} registros en total</span>
                    <span>Sistema Ganadero v1.0</span>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- ========================================================= -->
<!-- MODAL 1: REGISTRAR / EDITAR ANIMAL (CREATE & UPDATE)      -->
<!-- ========================================================= -->
<div id="modal-ganado" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6 modal-backdrop">
    <div class="bg-surface-container-lowest rounded-modal modal-dialog-form shadow-ambient-lvl2 flex flex-col max-h-[90vh] overflow-hidden border border-outline-variant modal-content">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant bg-surface">
            <h2 id="modal-ganado-titulo" class="text-lg font-semibold text-on-surface">Registrar / Editar Animal</h2>
            <button onclick="cerrarModalGanado()" class="text-on-surface-variant hover:text-on-surface transition-colors rounded-full p-1 hover:bg-surface-container-highest">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Form -->
        <form id="form-ganado" method="POST" action="{{ route('ganado.store') }}" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <input type="hidden" id="form-method" name="_method" value="POST">
            
            <div class="px-6 py-6 overflow-y-auto space-y-6 flex-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Arete -->
                    <div>
                        <label for="input-arete" class="block text-xs font-semibold text-on-surface mb-2">Arete / Número de Arete *</label>
                        <input type="text" id="input-arete" name="arete" required placeholder="Ej: AR-001" 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/60"/>
                    </div>

                    <!-- Nombre -->
                    <div>
                        <label for="input-nombre" class="block text-xs font-semibold text-on-surface mb-2">Nombre del Animal</label>
                        <input type="text" id="input-nombre" name="nombre" placeholder="Ej: Relámpago (Opcional)" 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/60"/>
                    </div>

                    <!-- Raza -->
                    <div>
                        <label for="select-raza" class="block text-xs font-semibold text-on-surface mb-2">Raza *</label>
                        <select id="select-raza" name="raza" required class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                            <option value="" disabled selected>Seleccionar Raza</option>
                            <option value="Angus">Angus</option>
                            <option value="Hereford">Hereford</option>
                            <option value="Brahman">Brahman</option>
                            <option value="Holstein">Holstein</option>
                            <option value="Charolais">Charolais</option>
                            <option value="Simmental">Simmental</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <!-- Sexo -->
                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-2">Sexo *</label>
                        <div class="flex gap-6 items-center h-10">
                            <label class="flex items-center gap-2 cursor-pointer text-sm text-on-surface">
                                <input type="radio" id="sexo-macho" name="sexo" value="Macho" checked class="h-4 w-4 text-primary focus:ring-primary"/>
                                <span>Macho</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer text-sm text-on-surface">
                                <input type="radio" id="sexo-hembra" name="sexo" value="Hembra" class="h-4 w-4 text-primary focus:ring-primary"/>
                                <span>Hembra</span>
                            </label>
                        </div>
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div>
                        <label for="input-fecha" class="block text-xs font-semibold text-on-surface mb-2">Fecha de Nacimiento</label>
                        <input type="date" id="input-fecha" name="fecha_nacimiento" 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"/>
                    </div>

                    <!-- Peso Actual -->
                    <div>
                        <label for="input-peso" class="block text-xs font-semibold text-on-surface mb-2">Peso Actual (kg)</label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="number" step="0.01" id="input-peso" name="peso_actual" placeholder="0.00" 
                                   class="w-full rounded-md border border-outline-variant bg-surface-container-low pl-4 pr-12 py-2.5 font-mono-data text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/60"/>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-on-surface-variant text-sm font-semibold">kg</div>
                        </div>
                    </div>

                    <!-- Categoría -->
                    <div>
                        <label for="select-categoria" class="block text-xs font-semibold text-on-surface mb-2">Categoría *</label>
                        <select id="select-categoria" name="categoria" required class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                            <option value="" disabled selected>Seleccionar Categoría</option>
                            <option value="Ternero">Ternero</option>
                            <option value="Novillo">Novillo</option>
                            <option value="Vaca">Vaca</option>
                            <option value="Toro">Toro</option>
                        </select>
                    </div>

                    <!-- Estatus -->
                    <div>
                        <label for="select-estatus" class="block text-xs font-semibold text-on-surface mb-2">Estatus *</label>
                        <select id="select-estatus" name="estatus" required class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                            <option value="Activo">Activo</option>
                            <option value="En Cuarentena">En Cuarentena</option>
                            <option value="Vendido">Vendido</option>
                            <option value="Fallecido">Fallecido</option>
                        </select>
                    </div>

                    <!-- ID Madre -->
                    <div class="col-span-1 md:col-span-2">
                        <label for="input-madre" class="block text-xs font-semibold text-on-surface mb-2">ID / Arete Madre (Opcional)</label>
                        <input type="number" id="input-madre" name="id_madre" placeholder="Ej: 45" 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/60"/>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-outline-variant bg-surface flex justify-end gap-3 rounded-b-modal">
                <button type="button" onclick="cerrarModalGanado()" class="px-5 py-2.5 rounded-md border border-outline-variant text-on-surface-variant hover:text-on-surface text-xs font-semibold hover:bg-surface-container-highest transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-md bg-primary text-on-primary text-xs font-semibold hover:bg-primary/90 shadow-sm transition-all">
                    Guardar Registro
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================= -->
<!-- MODAL 2: CONFIRMAR ELIMINACIÓN (DELETE CONFIRMATION)       -->
<!-- ========================================================= -->
<div id="modal-eliminar" class="fixed inset-0 z-50 hidden items-center justify-center p-4 modal-backdrop">
    <div class="bg-surface-container-lowest rounded-modal modal-dialog-confirm shadow-ambient-lvl2 p-6 relative overflow-hidden flex flex-col items-center text-center border border-outline-variant modal-content">
        <div class="w-14 h-14 rounded-full bg-error-container/30 border border-error/20 flex items-center justify-center mb-5 text-error">
            <span class="material-symbols-outlined text-[32px] fill">warning</span>
        </div>
        
        <h3 class="text-xl font-bold text-on-surface mb-2">¿Desea eliminar el registro?</h3>
        
        <p class="text-xs text-on-surface-variant mb-6 px-2 leading-relaxed">
            Está a punto de eliminar el registro del animal con Arete 
            <strong id="eliminar-arete-text" class="font-mono-data text-primary font-bold bg-surface-container-low px-2 py-0.5 rounded border border-outline-variant">#AR-001</strong>. 
            Esta acción es permanente.
        </p>

        <form id="form-eliminar" method="POST" action="" class="w-full flex items-center justify-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="cerrarModalEliminar()" class="w-full h-10 px-4 rounded-md border border-outline-variant bg-transparent text-on-surface text-xs font-semibold hover:bg-surface-container-high transition-colors">
                Cancelar
            </button>
            <button type="submit" class="w-full h-10 px-4 rounded-md bg-error text-on-error text-xs font-semibold hover:bg-error/90 transition-colors shadow-sm">
                Sí, Eliminar
            </button>
        </form>
    </div>
</div>

<!-- ========================================================= -->
<!-- MODAL 3: NOTIFICACIÓN DE ÉXITO (SUCCESS CONFIRMATION)     -->
<!-- ========================================================= -->
<div id="modal-exito" class="fixed inset-0 z-[60] {{ session('success') ? 'flex' : 'hidden' }} items-center justify-center p-4 modal-backdrop">
    <div class="bg-surface-container-lowest rounded-modal modal-dialog-sm shadow-ambient-lvl2 p-6 relative overflow-hidden flex flex-col items-center text-center border border-outline-variant modal-content">
        <div class="w-14 h-14 rounded-full bg-primary/20 flex items-center justify-center mb-4 text-primary border border-primary/30">
            <span class="material-symbols-outlined text-[36px] fill">check_circle</span>
        </div>
        
        <h3 id="modal-exito-titulo" class="text-lg font-bold text-on-surface mb-2">
            {{ session('title') ?? '¡Operación Exitosa!' }}
        </h3>
        
        <p id="modal-exito-mensaje" class="text-xs text-on-surface-variant mb-6 px-2 leading-relaxed">
            {{ session('success') ?? 'La acción se realizó correctamente.' }}
        </p>

        <button type="button" onclick="cerrarModalExito()" class="w-full h-10 px-6 rounded-md bg-primary text-on-primary text-xs font-semibold hover:bg-primary/90 transition-colors shadow-sm">
            Aceptar
        </button>
    </div>
</div>

<!-- ========================================================= -->
<!-- DRAWER: PANEL LATERAL DE DETALLE DEL ANIMAL (VIEW DETAIL)  -->
<!-- ========================================================= -->
<div id="drawer-overlay" class="fixed inset-0 modal-backdrop z-40 hidden transition-opacity" onclick="cerrarDrawerDetalle()"></div>

<aside id="drawer-detalle" class="fixed right-0 top-0 h-full w-full sm:w-[400px] md:w-[420px] bg-surface-container-lowest z-50 shadow-ambient-lvl2 transform translate-x-full transition-transform duration-300 flex flex-col border-l border-outline-variant">
    <!-- Drawer Header -->
    <header class="flex items-start justify-between p-6 border-b border-outline-variant bg-surface">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center border border-primary/20 text-primary">
                <span class="material-symbols-outlined text-2xl fill">pets</span>
            </div>
            <div>
                <h2 id="detail-arete" class="text-xl font-bold text-on-surface">Arete #AR-001</h2>
                <p id="detail-nombre" class="text-sm text-on-surface-variant">Relámpago</p>
            </div>
        </div>
        <button onclick="cerrarDrawerDetalle()" class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
    </header>

    <!-- Drawer Content -->
    <main class="flex-1 overflow-y-auto p-6 space-y-6">
        <!-- Quick Stats -->
        <section class="grid grid-cols-2 gap-4">
            <div class="bg-surface-container-low p-4 rounded-lg border border-outline-variant flex flex-col items-center justify-center">
                <span class="text-xs font-semibold text-on-surface-variant uppercase mb-1">Peso Actual</span>
                <span id="detail-peso" class="text-2xl font-bold text-primary">850 <span class="text-xs font-normal text-on-surface-variant">kg</span></span>
            </div>
            <div class="bg-surface-container-low p-4 rounded-lg border border-outline-variant flex flex-col items-center justify-center">
                <span class="text-xs font-semibold text-on-surface-variant uppercase mb-1">Estatus</span>
                <span id="detail-estatus-badge" class="px-2.5 py-1 rounded bg-primary/10 text-primary text-xs font-semibold">Activo</span>
            </div>
        </section>

        <!-- Detailed Info -->
        <section>
            <h3 class="text-sm font-semibold text-on-surface mb-3 uppercase tracking-wider">Ficha Técnica</h3>
            <div class="bg-surface-container-lowest rounded-lg border border-outline-variant overflow-hidden">
                <dl class="divide-y divide-outline-variant text-sm">
                    <div class="px-4 py-3 flex justify-between">
                        <dt class="text-on-surface-variant">Raza</dt>
                        <dd id="detail-raza" class="font-medium text-on-surface">Angus</dd>
                    </div>
                    <div class="px-4 py-3 flex justify-between">
                        <dt class="text-on-surface-variant">Sexo</dt>
                        <dd id="detail-sexo" class="font-medium text-on-surface">Macho</dd>
                    </div>
                    <div class="px-4 py-3 flex justify-between">
                        <dt class="text-on-surface-variant">Fecha de Nacimiento</dt>
                        <dd id="detail-fecha" class="font-medium text-on-surface">12/04/2021</dd>
                    </div>
                    <div class="px-4 py-3 flex justify-between">
                        <dt class="text-on-surface-variant">Categoría</dt>
                        <dd id="detail-categoria" class="font-medium text-on-surface">Toro</dd>
                    </div>
                    <div class="px-4 py-3 flex justify-between">
                        <dt class="text-on-surface-variant">ID Arete Madre</dt>
                        <dd id="detail-madre" class="font-mono-data text-primary font-bold">#AR-M045</dd>
                    </div>
                </dl>
            </div>
        </section>
    </main>

    <!-- Drawer Footer -->
    <footer class="p-6 border-t border-outline-variant bg-surface flex flex-col gap-3">
        <button id="btn-edit-from-drawer" class="w-full bg-primary text-on-primary text-xs font-semibold py-3 px-4 rounded-system hover:bg-primary-container transition-colors shadow-sm">
            Editar Registro
        </button>
        <button onclick="cerrarDrawerDetalle()" class="w-full bg-transparent border border-secondary text-secondary text-xs font-semibold py-3 px-4 rounded-system hover:bg-surface-container-low transition-colors">
            Cerrar Ficha
        </button>
    </footer>
</aside>

<!-- JavaScript Interactivity -->
<script>
    const baseUrl = "{{ url('ganado') }}";

    function abrirModalCrear() {
        document.getElementById('modal-ganado-titulo').innerText = 'Registrar Nuevo Animal';
        document.getElementById('form-ganado').action = baseUrl;
        document.getElementById('form-method').value = 'POST';
        document.getElementById('form-ganado').reset();
        document.getElementById('modal-ganado').classList.remove('hidden');
        document.getElementById('modal-ganado').classList.add('flex');
    }

    function abrirModalEditar(animal) {
        document.getElementById('modal-ganado-titulo').innerText = 'Editar Registro de Animal';
        document.getElementById('form-ganado').action = `${baseUrl}/${animal.id_animal}`;
        document.getElementById('form-method').value = 'PUT';

        document.getElementById('input-arete').value = animal.arete || '';
        document.getElementById('input-nombre').value = animal.nombre || '';
        document.getElementById('select-raza').value = animal.raza || '';
        
        if (animal.sexo === 'Hembra') {
            document.getElementById('sexo-hembra').checked = true;
        } else {
            document.getElementById('sexo-macho').checked = true;
        }

        document.getElementById('input-fecha').value = animal.fecha_nacimiento || '';
        document.getElementById('input-peso').value = animal.peso_actual || '';
        document.getElementById('select-categoria').value = animal.categoria || '';
        document.getElementById('select-estatus').value = animal.estatus || '';
        document.getElementById('input-madre').value = animal.id_madre || '';

        document.getElementById('modal-ganado').classList.remove('hidden');
        document.getElementById('modal-ganado').classList.add('flex');
    }

    function cerrarModalGanado() {
        document.getElementById('modal-ganado').classList.add('hidden');
        document.getElementById('modal-ganado').classList.remove('flex');
    }

    function abrirModalEliminar(id, arete) {
        document.getElementById('eliminar-arete-text').innerText = `#${arete}`;
        document.getElementById('form-eliminar').action = `${baseUrl}/${id}`;
        document.getElementById('modal-eliminar').classList.remove('hidden');
        document.getElementById('modal-eliminar').classList.add('flex');
    }

    function cerrarModalEliminar() {
        document.getElementById('modal-eliminar').classList.add('hidden');
        document.getElementById('modal-eliminar').classList.remove('flex');
    }

    function abrirModalExito(titulo, mensaje) {
        if (titulo) document.getElementById('modal-exito-titulo').innerText = titulo;
        if (mensaje) document.getElementById('modal-exito-mensaje').innerHTML = mensaje;
        document.getElementById('modal-exito').classList.remove('hidden');
        document.getElementById('modal-exito').classList.add('flex');
    }

    function cerrarModalExito() {
        document.getElementById('modal-exito').classList.add('hidden');
        document.getElementById('modal-exito').classList.remove('flex');
    }

    function abrirDrawerDetalle(animal) {
        document.getElementById('detail-arete').innerText = `Arete #${animal.arete}`;
        document.getElementById('detail-nombre').innerText = animal.nombre ? animal.nombre : 'Sin Nombre';
        document.getElementById('detail-peso').innerHTML = `${parseFloat(animal.peso_actual || 0).toFixed(0)} <span class="text-xs font-normal text-on-surface-variant">kg</span>`;
        document.getElementById('detail-raza').innerText = animal.raza || '-';
        document.getElementById('detail-sexo').innerText = animal.sexo || '-';
        document.getElementById('detail-fecha').innerText = animal.fecha_nacimiento ? animal.fecha_nacimiento : '-';
        document.getElementById('detail-categoria').innerText = animal.categoria || '-';
        document.getElementById('detail-madre').innerText = animal.id_madre ? `#${animal.id_madre}` : 'N/A';
        document.getElementById('detail-estatus-badge').innerText = animal.estatus || 'Activo';

        document.getElementById('btn-edit-from-drawer').onclick = function() {
            cerrarDrawerDetalle();
            abrirModalEditar(animal);
        };

        document.getElementById('drawer-overlay').classList.remove('hidden');
        document.getElementById('drawer-detalle').classList.remove('translate-x-full');
    }

    function cerrarDrawerDetalle() {
        document.getElementById('drawer-overlay').classList.add('hidden');
        document.getElementById('drawer-detalle').classList.add('translate-x-full');
    }

    // Top search bar sync
    document.getElementById('top-search-input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const val = this.value;
            window.location.href = `{{ route('ganado.index') }}?buscar=${encodeURIComponent(val)}`;
        }
    });

    // Sidebar toggle for small screens
    function toggleSidebar() {
        const sb = document.getElementById('sidebar');
        if (!sb) return;
        if (sb.classList.contains('-translate-x-full')) {
            sb.classList.remove('-translate-x-full');
        } else {
            sb.classList.add('-translate-x-full');
        }
    }
</script>
@endsection
