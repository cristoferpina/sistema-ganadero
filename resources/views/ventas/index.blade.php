@extends('layouts.app')

@section('title', 'Ventas y Bajas - Sistema Ganadero')

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
                <input id="top-search-input" type="text" placeholder="Buscar por contraparte o arete del animal..." 
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
            <a href="{{ route('historial-clinico.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-on-surface-variant hover:bg-surface-container-highest transition-all text-xs">
                <span class="material-symbols-outlined">medical_services</span> Historial Clínico
            </a>
            <a href="{{ route('ciclo-reproductivo.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-on-surface-variant hover:bg-surface-container-highest transition-all text-xs">
                <span class="material-symbols-outlined">diversity_1</span> Ciclos Reproductivos
            </a>
            <a href="{{ route('ventas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-primary font-semibold border-r-4 border-primary bg-surface-container-high text-xs">
                <span class="material-symbols-outlined fill">payments</span> Ventas y Bajas
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
                    <h1 class="text-2xl font-bold text-primary">Ventas, Compras y Movimientos</h1>
                    <p class="text-sm text-on-surface-variant mt-1">Transacciones financieras y bajas del rebaño ganadero.</p>
                </div>
                <button onclick="abrirModalCrearVenta()" class="bg-primary text-on-primary text-xs font-semibold px-5 py-2.5 rounded-system hover:bg-primary/90 transition-colors flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-sm">add_card</span>
                    Registrar Movimiento
                </button>
            </header>

            <!-- CRUD Module Container -->
            <div class="bg-surface-container-lowest rounded-system border border-outline-variant shadow-ambient-lvl1 overflow-hidden">
                <!-- Top Action Bar & Filters -->
                <form method="GET" action="{{ route('ventas.index') }}" class="p-4 sm:p-6 border-b border-outline-variant bg-surface-container-lowest flex flex-col md:flex-row gap-3 sm:gap-4 items-stretch md:items-center justify-between">
                    <div class="relative w-full md:w-[260px] lg:w-[320px]">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por Contraparte o Arete..." 
                               class="w-full pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-system text-xs sm:text-sm text-on-surface placeholder:text-on-surface-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"/>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 sm:gap-3 w-full md:w-auto">
                        <div class="relative flex-1 sm:flex-none">
                            <select name="tipo_movimiento" onchange="this.form.submit()" class="w-full sm:w-auto appearance-none bg-surface-container-low border border-outline-variant rounded-system pl-3 sm:pl-4 pr-9 py-2 text-xs sm:text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary min-w-[150px]">
                                <option value="">Todos los Movimientos</option>
                                <option value="venta" {{ request('tipo_movimiento') == 'venta' ? 'selected' : '' }}>Venta</option>
                                <option value="compra" {{ request('tipo_movimiento') == 'compra' ? 'selected' : '' }}>Compra</option>
                                <option value="muerte" {{ request('tipo_movimiento') == 'muerte' ? 'selected' : '' }}>Muerte</option>
                                <option value="baja" {{ request('tipo_movimiento') == 'baja' ? 'selected' : '' }}>Baja</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">arrow_drop_down</span>
                        </div>

                        @if(request()->hasAny(['buscar', 'tipo_movimiento']))
                        <a href="{{ route('ventas.index') }}" class="p-2 text-on-surface-variant hover:text-error transition-colors flex items-center" title="Limpiar filtros">
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
                                <th class="px-6 py-4 font-semibold">Movimiento</th>
                                <th class="px-6 py-4 font-semibold">Fecha</th>
                                <th class="px-6 py-4 font-semibold">Contraparte</th>
                                <th class="px-6 py-4 font-semibold">Precio / Monto</th>
                                <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant text-sm text-on-surface bg-surface-container-lowest">
                            @forelse($ventas as $item)
                            <tr class="hover:bg-surface-container-low/50 transition-colors group">
                                <td class="px-6 py-4 font-mono-data text-primary font-bold">#{{ $item->id_venta }}</td>
                                <td class="px-6 py-4 font-medium">
                                    @if($item->animal)
                                        <span class="text-primary font-bold font-mono-data">#{{ $item->animal->arete }}</span>
                                        @if($item->animal->nombre) <span class="text-xs text-on-surface-variant">({{ $item->animal->nombre }})</span> @endif
                                    @else
                                        <span class="text-on-surface-variant">Animal #{{ $item->id_animal }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->tipo_movimiento === 'venta')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-primary/10 text-primary text-xs font-semibold border border-primary/20">
                                            <span class="material-symbols-outlined text-[14px]">point_of_sale</span> Venta
                                        </span>
                                    @elseif($item->tipo_movimiento === 'compra')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-secondary-container text-on-secondary-container text-xs font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">shopping_cart</span> Compra
                                        </span>
                                    @elseif($item->tipo_movimiento === 'muerte')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-error/10 text-error text-xs font-semibold border border-error/20">
                                            <span class="material-symbols-outlined text-[14px]">heart_broken</span> Muerte
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-surface-container-high text-on-surface-variant text-xs font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">archive</span> Baja
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-mono-data">
                                    {{ \Carbon\Carbon::parse($item->fecha_movimiento)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 font-medium text-on-surface">{{ $item->contraparte ?? '-' }}</td>
                                <td class="px-6 py-4 font-mono-data font-bold text-primary">
                                    {{ $item->precio !== null ? '$' . number_format($item->precio, 2) : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1 opacity-90 group-hover:opacity-100 transition-opacity">
                                        <button onclick='abrirDrawerDetalleVenta(@json($item))' class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded transition-colors" title="Ver Detalle">
                                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                                        </button>
                                        <button onclick='abrirModalEditarVenta(@json($item))' class="p-1.5 text-on-surface-variant hover:text-secondary-fixed-dim hover:bg-secondary-container/50 rounded transition-colors" title="Editar">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>
                                        <button onclick="abrirModalEliminarVenta({{ $item->id_venta }})" class="p-1.5 text-on-surface-variant hover:text-error hover:bg-error-container/50 rounded transition-colors" title="Eliminar">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-outline">payments</span>
                                    <p class="font-medium text-base">No hay registros de ventas o movimientos.</p>
                                    <p class="text-xs mt-1">Haz clic en "+ Registrar Movimiento" para agregar el primero.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Stats -->
                <div class="px-6 py-4 border-t border-outline-variant bg-surface-container-lowest flex items-center justify-between text-xs text-on-surface-variant">
                    <span>Mostrando {{ count($ventas) }} transacciones</span>
                    <span>Sistema Ganadero v1.0</span>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- ========================================================= -->
<!-- MODAL: REGISTRAR / EDITAR VENTA O MOVIMIENTO              -->
<!-- ========================================================= -->
<div id="modal-venta" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6 modal-backdrop">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-2xl shadow-ambient-lvl2 flex flex-col max-h-[90vh] overflow-hidden border border-outline-variant modal-content">
        <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant bg-surface">
            <h2 id="modal-venta-titulo" class="text-lg font-semibold text-on-surface">Registrar Movimiento</h2>
            <button onclick="cerrarModalVenta()" class="text-on-surface-variant hover:text-on-surface transition-colors rounded-full p-1 hover:bg-surface-container-highest">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="form-venta" method="POST" action="{{ route('ventas.store') }}" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <input type="hidden" id="venta-form-method" name="_method" value="POST">
            
            <div class="px-6 py-6 overflow-y-auto space-y-4 flex-1">
                <!-- Seleccionar Animal -->
                <div>
                    <label for="select-animal-venta" class="block text-xs font-semibold text-on-surface mb-1.5">Animal (Arete - Nombre) *</label>
                    <select id="select-animal-venta" name="id_animal" required class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                        <option value="" disabled selected>Seleccionar Animal</option>
                        @foreach($animales as $anim)
                            <option value="{{ $anim->id_animal }}">Arete #{{ $anim->arete }} {{ $anim->nombre ? ' - '.$anim->nombre : '' }} ({{ $anim->raza }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tipo Movimiento -->
                    <div>
                        <label for="select-tipo-movimiento" class="block text-xs font-semibold text-on-surface mb-1.5">Tipo de Movimiento *</label>
                        <select id="select-tipo-movimiento" name="tipo_movimiento" required class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                            <option value="venta">Venta</option>
                            <option value="compra">Compra</option>
                            <option value="muerte">Muerte</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>

                    <!-- Fecha Movimiento -->
                    <div>
                        <label for="input-fecha-movimiento" class="block text-xs font-semibold text-on-surface mb-1.5">Fecha de Movimiento *</label>
                        <input type="date" id="input-fecha-movimiento" name="fecha_movimiento" required value="{{ date('Y-m-d') }}"
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"/>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Contraparte -->
                    <div>
                        <label for="input-contraparte" class="block text-xs font-semibold text-on-surface mb-1.5">Contraparte / Comprador / Vendedor</label>
                        <input type="text" id="input-contraparte" name="contraparte" placeholder="Ej: Ganadería El Sol S.A." 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/60"/>
                    </div>

                    <!-- Precio -->
                    <div>
                        <label for="input-precio" class="block text-xs font-semibold text-on-surface mb-1.5">Precio / Monto ($)</label>
                        <input type="number" step="0.01" id="input-precio" name="precio" placeholder="0.00" 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 font-mono-data text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/60"/>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-outline-variant bg-surface">
                <button type="button" onclick="cerrarModalVenta()" class="px-4 py-2.5 rounded-md border border-outline-variant text-xs font-semibold text-on-surface hover:bg-surface-container-highest transition-colors">
                    Cancelar
                </button>
                <button type="submit" id="btn-guardar-venta" class="px-6 py-2.5 rounded-md bg-primary text-on-primary text-xs font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                    Guardar Movimiento
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL ELIMINAR -->
<div id="modal-eliminar-venta" class="fixed inset-0 z-50 hidden items-center justify-center p-4 modal-backdrop">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-md p-6 shadow-ambient-lvl2 border border-outline-variant text-center space-y-4 modal-content">
        <div class="w-14 h-14 rounded-full bg-error-container/30 border border-error/20 text-error flex items-center justify-center mx-auto">
            <span class="material-symbols-outlined text-2xl">warning</span>
        </div>
        <div>
            <h3 class="text-lg font-bold text-on-surface">¿Eliminar movimiento?</h3>
            <p class="text-xs text-on-surface-variant mt-1">Esta acción eliminará el registro del movimiento seleccionado.</p>
        </div>
        <form id="form-eliminar-venta" method="POST" action="" class="flex items-center justify-center gap-3 pt-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="cerrarModalEliminarVenta()" class="w-full h-10 px-4 rounded-md border border-outline-variant text-xs font-semibold text-on-surface hover:bg-surface-container-highest transition-colors">
                Cancelar
            </button>
            <button type="submit" class="w-full h-10 px-5 rounded-md bg-error text-on-error text-xs font-semibold hover:bg-error/90 transition-colors shadow-sm">
                Sí, Eliminar
            </button>
        </form>
    </div>
</div>

<!-- DRAWER DETALLE -->
<div id="drawer-overlay-venta" class="fixed inset-0 modal-backdrop z-40 hidden" onclick="cerrarDrawerDetalleVenta()"></div>
<aside id="drawer-detalle-venta" class="fixed top-0 right-0 h-full w-full max-w-md bg-surface-container-lowest border-l border-outline-variant z-50 shadow-ambient-lvl2 transform translate-x-full transition-transform duration-300 flex flex-col">
    <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant bg-surface">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">payments</span>
            <h3 class="text-base font-bold text-on-surface">Detalle de Transacción / Movimiento</h3>
        </div>
        <button onclick="cerrarDrawerDetalleVenta()" class="text-on-surface-variant hover:text-on-surface p-1 rounded-full hover:bg-surface-container-highest">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <div class="p-6 space-y-6 flex-1 overflow-y-auto">
        <div class="space-y-3">
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">ID Venta / Movimiento</span>
                <span id="detail-venta-id" class="font-mono-data text-primary font-bold">#1</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Animal</span>
                <span id="detail-venta-animal" class="font-bold text-primary">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Tipo Movimiento</span>
                <span id="detail-venta-tipo" class="font-semibold text-on-surface uppercase">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Fecha Movimiento</span>
                <span id="detail-venta-fecha" class="font-mono-data text-on-surface">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Contraparte</span>
                <span id="detail-venta-contraparte" class="font-medium text-on-surface">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Precio / Monto</span>
                <span id="detail-venta-precio" class="font-mono-data text-primary font-bold text-sm">-</span>
            </div>
        </div>
    </div>

    <div class="p-6 border-t border-outline-variant bg-surface-container-low flex gap-3">
        <button id="btn-edit-venta-from-drawer" class="flex-1 py-2.5 bg-primary text-on-primary rounded-md text-xs font-semibold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 shadow-sm">
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
    const ventaBaseUrl = "{{ url('ventas') }}";

    function abrirModalCrearVenta() {
        document.getElementById('modal-venta-titulo').innerText = 'Registrar Movimiento';
        document.getElementById('form-venta').action = ventaBaseUrl;
        document.getElementById('venta-form-method').value = 'POST';
        document.getElementById('form-venta').reset();
        document.getElementById('btn-guardar-venta').innerText = 'Guardar Movimiento';

        document.getElementById('modal-venta').classList.remove('hidden');
        document.getElementById('modal-venta').classList.add('flex');
    }

    function abrirModalEditarVenta(item) {
        document.getElementById('modal-venta-titulo').innerText = `Editar Movimiento #${item.id_venta}`;
        document.getElementById('form-venta').action = `${ventaBaseUrl}/${item.id_venta}`;
        document.getElementById('venta-form-method').value = 'PUT';

        document.getElementById('select-animal-venta').value = item.id_animal || '';
        document.getElementById('select-tipo-movimiento').value = item.tipo_movimiento || 'venta';
        document.getElementById('input-fecha-movimiento').value = item.fecha_movimiento || '';
        document.getElementById('input-contraparte').value = item.contraparte || '';
        document.getElementById('input-precio').value = item.precio !== null ? item.precio : '';

        document.getElementById('btn-guardar-venta').innerText = 'Actualizar Movimiento';

        document.getElementById('modal-venta').classList.remove('hidden');
        document.getElementById('modal-venta').classList.add('flex');
    }

    function cerrarModalVenta() {
        document.getElementById('modal-venta').classList.add('hidden');
        document.getElementById('modal-venta').classList.remove('flex');
    }

    function abrirModalEliminarVenta(id) {
        document.getElementById('form-eliminar-venta').action = `${ventaBaseUrl}/${id}`;
        document.getElementById('modal-eliminar-venta').classList.remove('hidden');
        document.getElementById('modal-eliminar-venta').classList.add('flex');
    }

    function cerrarModalEliminarVenta() {
        document.getElementById('modal-eliminar-venta').classList.add('hidden');
        document.getElementById('modal-eliminar-venta').classList.remove('flex');
    }

    function abrirDrawerDetalleVenta(item) {
        document.getElementById('detail-venta-id').innerText = `#${item.id_venta}`;
        document.getElementById('detail-venta-animal').innerText = item.animal ? `#${item.animal.arete} ${item.animal.nombre ? '- '+item.animal.nombre : ''}` : `#${item.id_animal}`;
        document.getElementById('detail-venta-tipo').innerText = item.tipo_movimiento || '-';
        document.getElementById('detail-venta-fecha').innerText = item.fecha_movimiento || '-';
        document.getElementById('detail-venta-contraparte').innerText = item.contraparte || '-';
        document.getElementById('detail-venta-precio').innerText = item.precio !== null ? `$${parseFloat(item.precio).toFixed(2)}` : '-';

        document.getElementById('btn-edit-venta-from-drawer').onclick = function() {
            cerrarDrawerDetalleVenta();
            abrirModalEditarVenta(item);
        };

        document.getElementById('drawer-overlay-venta').classList.remove('hidden');
        document.getElementById('drawer-detalle-venta').classList.remove('translate-x-full');
    }

    function cerrarDrawerDetalleVenta() {
        document.getElementById('drawer-overlay-venta').classList.add('hidden');
        document.getElementById('drawer-detalle-venta').classList.add('translate-x-full');
    }

    document.getElementById('top-search-input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            window.location.href = `{{ route('ventas.index') }}?buscar=${encodeURIComponent(this.value)}`;
        }
    });

</script>
@endsection
