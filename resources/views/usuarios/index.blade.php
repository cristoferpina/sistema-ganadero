@extends('layouts.app')

@section('title', 'Gestión de Usuarios - Sistema Ganadero')

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
                <input id="top-search-input" type="text" placeholder="Buscar usuario por nombre o usuario..." 
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
            <a href="{{ route('ciclo-reproductivo.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-on-surface-variant hover:bg-surface-container-highest transition-all text-xs">
                <span class="material-symbols-outlined">diversity_1</span> Ciclos Reproductivos
            </a>
            <a href="{{ route('ventas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-on-surface-variant hover:bg-surface-container-highest transition-all text-xs">
                <span class="material-symbols-outlined">payments</span> Ventas y Bajas
            </a>
            <a href="{{ route('usuarios.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-primary font-semibold border-r-4 border-primary bg-surface-container-high text-xs">
                <span class="material-symbols-outlined fill">manage_accounts</span> Usuarios
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
                    <h1 class="text-2xl font-bold text-primary">Usuarios del Sistema</h1>
                    <p class="text-sm text-on-surface-variant mt-1">Gestión de acceso, roles (Administrador/Operador) y estatus de cuentas.</p>
                </div>
                <button onclick="abrirModalCrearUsuario()" class="bg-primary text-on-primary text-xs font-semibold px-5 py-2.5 rounded-system hover:bg-primary/90 transition-colors flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-sm">person_add</span>
                    Registrar Usuario
                </button>
            </header>

            <!-- CRUD Module Container -->
            <div class="bg-surface-container-lowest rounded-system border border-outline-variant shadow-ambient-lvl1 overflow-hidden">
                <!-- Top Action Bar & Filters -->
                <form method="GET" action="{{ route('usuarios.index') }}" class="p-4 sm:p-6 border-b border-outline-variant bg-surface-container-lowest flex flex-col md:flex-row gap-3 sm:gap-4 items-stretch md:items-center justify-between">
                    <!-- Search -->
                    <div class="relative w-full md:w-[260px] lg:w-[320px]">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por Nombre, Usuario o Correo..." 
                               class="w-full pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-system text-xs sm:text-sm text-on-surface placeholder:text-on-surface-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"/>
                    </div>
                    
                    <!-- Filters -->
                    <div class="flex flex-wrap gap-2 sm:gap-3 w-full md:w-auto">
                        <div class="relative flex-1 sm:flex-none">
                            <select name="rol" onchange="this.form.submit()" class="w-full sm:w-auto appearance-none bg-surface-container-low border border-outline-variant rounded-system pl-3 sm:pl-4 pr-9 py-2 text-xs sm:text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary min-w-[130px]">
                                <option value="">Todos los Roles</option>
                                <option value="administrador" {{ request('rol') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                <option value="operador" {{ request('rol') == 'operador' ? 'selected' : '' }}>Operador</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">arrow_drop_down</span>
                        </div>

                        <div class="relative flex-1 sm:flex-none">
                            <select name="estatus" onchange="this.form.submit()" class="w-full sm:w-auto appearance-none bg-surface-container-low border border-outline-variant rounded-system pl-3 sm:pl-4 pr-9 py-2 text-xs sm:text-sm text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary min-w-[130px]">
                                <option value="">Todos los Estatus</option>
                                <option value="activo" {{ request('estatus') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ request('estatus') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">arrow_drop_down</span>
                        </div>

                        @if(request()->hasAny(['buscar', 'rol', 'estatus']))
                        <a href="{{ route('usuarios.index') }}" class="p-2 text-on-surface-variant hover:text-error transition-colors flex items-center" title="Limpiar filtros">
                            <span class="material-symbols-outlined">filter_alt_off</span>
                        </a>
                        @endif
                    </div>
                </form>

                <!-- Data Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse min-w-[900px]">
                        <thead class="bg-surface-container-low text-xs text-on-surface-variant uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-semibold w-16">ID</th>
                                <th class="px-6 py-4 font-semibold">Nombre Completo</th>
                                <th class="px-6 py-4 font-semibold">Usuario</th>
                                <th class="px-6 py-4 font-semibold">Correo Electrónico</th>
                                <th class="px-6 py-4 font-semibold">Rol</th>
                                <th class="px-6 py-4 font-semibold">Estatus</th>
                                <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant text-sm text-on-surface bg-surface-container-lowest">
                            @forelse($usuarios as $user)
                            <tr class="hover:bg-surface-container-low/50 transition-colors group">
                                <td class="px-6 py-4 font-mono-data text-primary font-bold">#{{ $user->id_usuario }}</td>
                                <td class="px-6 py-4 font-medium flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-container/40 text-primary flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($user->nombre_completo, 0, 2) }}
                                    </div>
                                    <span>{{ $user->nombre_completo }}</span>
                                </td>
                                <td class="px-6 py-4 font-mono-data text-on-surface font-semibold">@ {{ $user->nombre_usuario }}</td>
                                <td class="px-6 py-4 font-mono-data text-on-surface-variant">{{ $user->correo ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($user->rol === 'administrador')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-secondary-container text-on-secondary-container text-xs font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">shield_person</span> Administrador
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-surface-container-high text-on-surface-variant text-xs font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">person</span> Operador
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->estatus === 'activo')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-primary/10 text-primary text-xs font-semibold border border-primary/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-error/10 text-error text-xs font-semibold border border-error/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-error"></span> Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1 opacity-90 group-hover:opacity-100 transition-opacity">
                                        <button onclick='abrirDrawerDetalleUsuario(@json($user))' class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded transition-colors" title="Ver Detalle">
                                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                                        </button>
                                        <button onclick='abrirModalEditarUsuario(@json($user))' class="p-1.5 text-on-surface-variant hover:text-secondary-fixed-dim hover:bg-secondary-container/50 rounded transition-colors" title="Editar">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>
                                        <button onclick="abrirModalEliminarUsuario({{ $user->id_usuario }}, '{{ addslashes($user->nombre_completo) }}')" class="p-1.5 text-on-surface-variant hover:text-error hover:bg-error-container/50 rounded transition-colors" title="Eliminar">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-outline">group_off</span>
                                    <p class="font-medium text-base">No se encontraron usuarios registrados.</p>
                                    <p class="text-xs mt-1">Haz clic en "+ Registrar Usuario" para agregar uno.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Stats -->
                <div class="px-6 py-4 border-t border-outline-variant bg-surface-container-lowest flex items-center justify-between text-xs text-on-surface-variant">
                    <span>Mostrando {{ count($usuarios) }} usuarios</span>
                    <span>Sistema Ganadero v1.0</span>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- ========================================================= -->
<!-- MODAL: REGISTRAR / EDITAR USUARIO                         -->
<!-- ========================================================= -->
<div id="modal-usuario" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6 modal-backdrop">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-2xl shadow-ambient-lvl2 flex flex-col max-h-[90vh] overflow-hidden border border-outline-variant modal-content">
        <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant bg-surface">
            <h2 id="modal-usuario-titulo" class="text-lg font-semibold text-on-surface">Registrar / Editar Usuario</h2>
            <button onclick="cerrarModalUsuario()" class="text-on-surface-variant hover:text-on-surface transition-colors rounded-full p-1 hover:bg-surface-container-highest">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="form-usuario" method="POST" action="{{ route('usuarios.store') }}" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <input type="hidden" id="usuario-form-method" name="_method" value="POST">
            
            <div class="px-6 py-6 overflow-y-auto space-y-4 flex-1">
                <div>
                    <label for="input-nombre-completo" class="block text-xs font-semibold text-on-surface mb-1.5">Nombre Completo *</label>
                    <input type="text" id="input-nombre-completo" name="nombre_completo" required placeholder="Ej: Carlos Ramírez" 
                           class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/60"/>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="input-nombre-usuario" class="block text-xs font-semibold text-on-surface mb-1.5">Nombre de Usuario *</label>
                        <input type="text" id="input-nombre-usuario" name="nombre_usuario" required placeholder="Ej: cramirez" 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/60"/>
                    </div>
                    <div>
                        <label for="input-correo" class="block text-xs font-semibold text-on-surface mb-1.5">Correo Electrónico</label>
                        <input type="email" id="input-correo" name="correo" placeholder="correo@ejemplo.com" 
                               class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/60"/>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="select-rol" class="block text-xs font-semibold text-on-surface mb-1.5">Rol *</label>
                        <select id="select-rol" name="rol" required class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                            <option value="operador">Operador</option>
                            <option value="administrador">Administrador</option>
                        </select>
                    </div>
                    <div>
                        <label for="select-estatus-user" class="block text-xs font-semibold text-on-surface mb-1.5">Estatus *</label>
                        <select id="select-estatus-user" name="estatus" required class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="input-contrasena" class="block text-xs font-semibold text-on-surface mb-1.5" id="label-contrasena">Contraseña *</label>
                    <input type="password" id="input-contrasena" name="contrasena" placeholder="Contraseña de acceso" 
                           class="w-full rounded-md border border-outline-variant bg-surface-container-low px-4 py-2.5 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/60"/>
                    <p id="help-contrasena" class="text-[11px] text-on-surface-variant mt-1 hidden">Deja vacío si no deseas modificar la contraseña actual.</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-outline-variant bg-surface">
                <button type="button" onclick="cerrarModalUsuario()" class="px-4 py-2.5 rounded-md border border-outline-variant text-xs font-semibold text-on-surface hover:bg-surface-container-highest transition-colors">
                    Cancelar
                </button>
                <button type="submit" id="btn-guardar-usuario" class="px-6 py-2.5 rounded-md bg-primary text-on-primary text-xs font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                    Guardar Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL CONFIRMAR ELIMINACIÓN -->
<div id="modal-eliminar-usuario" class="fixed inset-0 z-50 hidden items-center justify-center p-4 modal-backdrop">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-md p-6 shadow-ambient-lvl2 border border-outline-variant text-center space-y-4 modal-content">
        <div class="w-14 h-14 rounded-full bg-error-container/30 border border-error/20 text-error flex items-center justify-center mx-auto">
            <span class="material-symbols-outlined text-2xl">warning</span>
        </div>
        <div>
            <h3 class="text-lg font-bold text-on-surface">¿Eliminar usuario?</h3>
            <p class="text-xs text-on-surface-variant mt-1">Está a punto de eliminar al usuario <span id="eliminar-usuario-name" class="font-bold text-primary"></span>.</p>
        </div>
        <form id="form-eliminar-usuario" method="POST" action="" class="flex items-center justify-center gap-3 pt-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="cerrarModalEliminarUsuario()" class="w-full h-10 px-4 rounded-md border border-outline-variant text-xs font-semibold text-on-surface hover:bg-surface-container-highest transition-colors">
                Cancelar
            </button>
            <button type="submit" class="w-full h-10 px-5 rounded-md bg-error text-on-error text-xs font-semibold hover:bg-error/90 transition-colors shadow-sm">
                Sí, Eliminar
            </button>
        </form>
    </div>
</div>

<!-- DRAWER DETALLE -->
<div id="drawer-overlay-usuario" class="fixed inset-0 modal-backdrop z-40 hidden" onclick="cerrarDrawerDetalleUsuario()"></div>
<aside id="drawer-detalle-usuario" class="fixed top-0 right-0 h-full w-full max-w-md bg-surface-container-lowest border-l border-outline-variant z-50 shadow-ambient-lvl2 transform translate-x-full transition-transform duration-300 flex flex-col">
    <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant bg-surface">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">manage_accounts</span>
            <h3 class="text-base font-bold text-on-surface">Detalle de Usuario</h3>
        </div>
        <button onclick="cerrarDrawerDetalleUsuario()" class="text-on-surface-variant hover:text-on-surface p-1 rounded-full hover:bg-surface-container-highest">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <div class="p-6 space-y-6 flex-1 overflow-y-auto">
        <div class="flex items-center gap-4 p-4 rounded-system bg-surface-container-low border border-outline-variant">
            <div class="w-12 h-12 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-base uppercase">
                <span id="detail-user-avatar">US</span>
            </div>
            <div>
                <h4 id="detail-user-name" class="font-bold text-base text-on-surface">Nombre</h4>
                <p id="detail-user-username" class="text-xs text-primary font-mono-data font-semibold">@usuario</p>
            </div>
        </div>

        <div class="space-y-3">
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">ID Usuario</span>
                <span id="detail-user-id" class="font-mono-data text-primary font-bold">#1</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Correo Electrónico</span>
                <span id="detail-user-email" class="font-mono-data text-on-surface">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Rol</span>
                <span id="detail-user-rol" class="font-semibold text-on-surface">-</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Estatus</span>
                <span id="detail-user-estatus" class="font-semibold text-on-surface">-</span>
            </div>
        </div>
    </div>

    <div class="p-6 border-t border-outline-variant bg-surface-container-low flex gap-3">
        <button id="btn-edit-user-from-drawer" class="flex-1 py-2.5 bg-primary text-on-primary rounded-md text-xs font-semibold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 shadow-sm">
            <span class="material-symbols-outlined text-sm">edit</span> Editar Usuario
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
    const userBaseUrl = "{{ url('usuarios') }}";

    function abrirModalCrearUsuario() {
        document.getElementById('modal-usuario-titulo').innerText = 'Registrar Nuevo Usuario';
        document.getElementById('form-usuario').action = userBaseUrl;
        document.getElementById('usuario-form-method').value = 'POST';
        document.getElementById('form-usuario').reset();
        
        document.getElementById('input-contrasena').required = true;
        document.getElementById('label-contrasena').innerText = 'Contraseña *';
        document.getElementById('help-contrasena').classList.add('hidden');
        document.getElementById('btn-guardar-usuario').innerText = 'Guardar Usuario';

        document.getElementById('modal-usuario').classList.remove('hidden');
        document.getElementById('modal-usuario').classList.add('flex');
    }

    function abrirModalEditarUsuario(user) {
        document.getElementById('modal-usuario-titulo').innerText = `Editar Usuario: ${user.nombre_completo}`;
        document.getElementById('form-usuario').action = `${userBaseUrl}/${user.id_usuario}`;
        document.getElementById('usuario-form-method').value = 'PUT';

        document.getElementById('input-nombre-completo').value = user.nombre_completo || '';
        document.getElementById('input-nombre-usuario').value = user.nombre_usuario || '';
        document.getElementById('input-correo').value = user.correo || '';
        document.getElementById('select-rol').value = user.rol || 'operador';
        document.getElementById('select-estatus-user').value = user.estatus || 'activo';
        
        document.getElementById('input-contrasena').value = '';
        document.getElementById('input-contrasena').required = false;
        document.getElementById('label-contrasena').innerText = 'Contraseña (Opcional)';
        document.getElementById('help-contrasena').classList.remove('hidden');
        document.getElementById('btn-guardar-usuario').innerText = 'Actualizar Usuario';

        document.getElementById('modal-usuario').classList.remove('hidden');
        document.getElementById('modal-usuario').classList.add('flex');
    }

    function cerrarModalUsuario() {
        document.getElementById('modal-usuario').classList.add('hidden');
        document.getElementById('modal-usuario').classList.remove('flex');
    }

    function abrirModalEliminarUsuario(id, name) {
        document.getElementById('eliminar-usuario-name').innerText = `"${name}"`;
        document.getElementById('form-eliminar-usuario').action = `${userBaseUrl}/${id}`;
        document.getElementById('modal-eliminar-usuario').classList.remove('hidden');
        document.getElementById('modal-eliminar-usuario').classList.add('flex');
    }

    function cerrarModalEliminarUsuario() {
        document.getElementById('modal-eliminar-usuario').classList.add('hidden');
        document.getElementById('modal-eliminar-usuario').classList.remove('flex');
    }

    function abrirDrawerDetalleUsuario(user) {
        document.getElementById('detail-user-id').innerText = `#${user.id_usuario}`;
        document.getElementById('detail-user-name').innerText = user.nombre_completo || 'Sin Nombre';
        document.getElementById('detail-user-username').innerText = `@${user.nombre_usuario || ''}`;
        document.getElementById('detail-user-email').innerText = user.correo || '-';
        document.getElementById('detail-user-rol').innerText = user.rol || '-';
        document.getElementById('detail-user-estatus').innerText = user.estatus || '-';
        document.getElementById('detail-user-avatar').innerText = (user.nombre_completo || 'US').substring(0, 2).toUpperCase();

        document.getElementById('btn-edit-user-from-drawer').onclick = function() {
            cerrarDrawerDetalleUsuario();
            abrirModalEditarUsuario(user);
        };

        document.getElementById('drawer-overlay-usuario').classList.remove('hidden');
        document.getElementById('drawer-detalle-usuario').classList.remove('translate-x-full');
    }

    function cerrarDrawerDetalleUsuario() {
        document.getElementById('drawer-overlay-usuario').classList.add('hidden');
        document.getElementById('drawer-detalle-usuario').classList.add('translate-x-full');
    }

    document.getElementById('top-search-input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            window.location.href = `{{ route('usuarios.index') }}?buscar=${encodeURIComponent(this.value)}`;
        }
    });

</script>
@endsection
