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
                <input id="top-search-input" type="text" placeholder="Buscar usuario por nombre o correo..." 
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
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-system text-primary font-semibold border-r-4 border-primary bg-surface-container-high text-xs">
                <span class="material-symbols-outlined fill">group</span> Usuarios
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
                    <p class="text-sm text-on-surface-variant mt-1">Administración de cuentas y usuarios registrados.</p>
                </div>
                <button onclick="abrirModalCrearUsuario()" class="bg-primary text-on-primary text-xs font-semibold px-5 py-2.5 rounded-system hover:bg-primary/90 transition-colors flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-sm">person_add</span>
                    Registrar Usuario
                </button>
            </header>

            <!-- CRUD Module Container -->
            <div class="bg-surface-container-lowest rounded-system border border-outline-variant shadow-ambient-lvl1 overflow-hidden">
                <!-- Top Action Bar & Filters -->
                <form method="GET" action="{{ route('users.index') }}" class="p-6 border-b border-outline-variant bg-surface-container-lowest flex flex-col lg:flex-row gap-4 items-center justify-between">
                    <!-- Search -->
                    <div class="relative w-full lg:w-[360px]">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por Nombre o Correo Electrónico..." 
                               class="w-full pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-system text-sm text-on-surface placeholder:text-on-surface-variant focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all"/>
                    </div>
                    
                    <div class="flex items-center gap-3 w-full lg:w-auto justify-end">
                        @if(request()->has('buscar'))
                        <a href="{{ route('users.index') }}" class="p-2 text-on-surface-variant hover:text-error transition-colors flex items-center gap-1 text-xs font-medium" title="Limpiar búsqueda">
                            <span class="material-symbols-outlined">filter_alt_off</span> Limpiar
                        </a>
                        @endif
                    </div>
                </form>

                <!-- Data Table -->
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse min-w-[800px]">
                        <thead class="bg-surface-container-low text-xs text-on-surface-variant uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4 font-semibold w-16">ID</th>
                                <th class="px-6 py-4 font-semibold">Nombre de Usuario</th>
                                <th class="px-6 py-4 font-semibold">Correo Electrónico</th>
                                <th class="px-6 py-4 font-semibold">Fecha Registro</th>
                                <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant text-sm text-on-surface bg-surface-container-lowest">
                            @forelse($users as $user)
                            <tr class="hover:bg-surface-container-low/50 transition-colors group">
                                <td class="px-6 py-4 font-mono-data text-primary font-bold">#{{ $user->id }}</td>
                                <td class="px-6 py-4 font-medium flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-container/40 text-primary flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <span>{{ $user->name }}</span>
                                </td>
                                <td class="px-6 py-4 font-mono-data text-on-surface-variant">{{ $user->email }}</td>
                                <td class="px-6 py-4 font-mono-data text-on-surface-variant">
                                    {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1 opacity-90 group-hover:opacity-100 transition-opacity">
                                        <button onclick='abrirDrawerDetalleUsuario(@json($user))' class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded transition-colors" title="Ver Detalle">
                                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                                        </button>
                                        <button onclick='abrirModalEditarUsuario(@json($user))' class="p-1.5 text-on-surface-variant hover:text-secondary-fixed-dim hover:bg-secondary-container/50 rounded transition-colors" title="Editar">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>
                                        <button onclick="abrirModalEliminarUsuario({{ $user->id }}, '{{ addslashes($user->name) }}')" class="p-1.5 text-on-surface-variant hover:text-error hover:bg-error-container/50 rounded transition-colors" title="Eliminar">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant">
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
                    <span>Mostrando {{ count($users) }} usuarios registrados</span>
                    <span>Sistema Ganadero v1.0</span>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- ========================================================= -->
<!-- MODAL 1: REGISTRAR / EDITAR USUARIO                       -->
<!-- ========================================================= -->
<div id="modal-usuario" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6 bg-on-surface/40 backdrop-blur-overlay">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-lg shadow-ambient-lvl2 flex flex-col max-h-[90vh] overflow-hidden border border-outline-variant">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant bg-surface">
            <h2 id="modal-usuario-titulo" class="text-lg font-semibold text-on-surface">Registrar / Editar Usuario</h2>
            <button onclick="cerrarModalUsuario()" class="text-on-surface-variant hover:text-on-surface transition-colors rounded-full p-1 hover:bg-surface-container-highest">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Form -->
        <form id="form-usuario" method="POST" action="{{ route('users.store') }}" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <input type="hidden" id="usuario-form-method" name="_method" value="POST">
            
            <div class="px-6 py-6 overflow-y-auto space-y-5 flex-1">
                <!-- Nombre -->
                <div>
                    <label for="input-usuario-name" class="block text-xs font-semibold text-on-surface mb-2">Nombre Completo *</label>
                    <input type="text" id="input-usuario-name" name="name" required placeholder="Ej: Juan Pérez" 
                           class="w-full rounded-md border border-outline-variant bg-surface-container-lowest px-4 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"/>
                </div>

                <!-- Email -->
                <div>
                    <label for="input-usuario-email" class="block text-xs font-semibold text-on-surface mb-2">Correo Electrónico *</label>
                    <input type="email" id="input-usuario-email" name="email" required placeholder="ejemplo@ganaderia.com" 
                           class="w-full rounded-md border border-outline-variant bg-surface-container-lowest px-4 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"/>
                </div>

                <!-- Password -->
                <div>
                    <label for="input-usuario-password" class="block text-xs font-semibold text-on-surface mb-2" id="label-password">Contraseña *</label>
                    <input type="password" id="input-usuario-password" name="password" placeholder="Mínimo 6 caracteres" 
                           class="w-full rounded-md border border-outline-variant bg-surface-container-lowest px-4 py-2 text-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"/>
                    <p id="help-password" class="text-[11px] text-on-surface-variant mt-1.5 hidden">Deja el campo vacío si no deseas cambiar la contraseña actual.</p>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-outline-variant bg-surface-container-low">
                <button type="button" onclick="cerrarModalUsuario()" class="px-4 py-2 rounded-md border border-outline-variant text-xs font-semibold text-on-surface hover:bg-surface-container-highest transition-colors">
                    Cancelar
                </button>
                <button type="submit" id="btn-guardar-usuario" class="px-5 py-2 rounded-md bg-primary text-on-primary text-xs font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                    Guardar Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ========================================================= -->
<!-- MODAL 2: CONFIRMAR ELIMINACIÓN                             -->
<!-- ========================================================= -->
<div id="modal-eliminar-usuario" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-on-surface/40 backdrop-blur-overlay">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-md p-6 shadow-ambient-lvl2 border border-outline-variant text-center space-y-4">
        <div class="w-12 h-12 rounded-full bg-error-container/30 text-error flex items-center justify-center mx-auto">
            <span class="material-symbols-outlined text-2xl">warning</span>
        </div>
        <div>
            <h3 class="text-lg font-bold text-on-surface">¿Eliminar usuario?</h3>
            <p class="text-xs text-on-surface-variant mt-1">Está a punto de eliminar el usuario <span id="eliminar-usuario-name" class="font-bold text-primary"></span>. Esta acción no se puede deshacer.</p>
        </div>
        <form id="form-eliminar-usuario" method="POST" action="" class="flex items-center justify-center gap-3 pt-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="cerrarModalEliminarUsuario()" class="px-4 py-2 rounded-md border border-outline-variant text-xs font-semibold text-on-surface hover:bg-surface-container-highest transition-colors">
                Cancelar
            </button>
            <button type="submit" class="px-5 py-2 rounded-md bg-error text-on-error text-xs font-semibold hover:bg-error/90 transition-colors shadow-sm">
                Sí, Eliminar
            </button>
        </form>
    </div>
</div>

<!-- ========================================================= -->
<!-- DRAWER: VER DETALLE DEL USUARIO                           -->
<!-- ========================================================= -->
<div id="drawer-overlay-usuario" class="fixed inset-0 bg-on-surface/40 backdrop-blur-overlay z-40 hidden" onclick="cerrarDrawerDetalleUsuario()"></div>
<aside id="drawer-detalle-usuario" class="fixed top-0 right-0 h-full w-full max-w-md bg-surface-container-lowest border-l border-outline-variant z-50 shadow-ambient-lvl2 transform translate-x-full transition-transform duration-300 flex flex-col">
    <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant bg-surface">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">account_circle</span>
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
                <p id="detail-user-email" class="text-xs text-on-surface-variant font-mono-data">correo@ejemplo.com</p>
            </div>
        </div>

        <div class="space-y-3">
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">ID Usuario</span>
                <span id="detail-user-id" class="font-mono-data text-primary font-bold">#1</span>
            </div>
            <div class="flex justify-between py-2 border-b border-outline-variant text-xs">
                <span class="text-on-surface-variant font-medium">Fecha de Registro</span>
                <span id="detail-user-created" class="font-mono-data text-on-surface">-</span>
            </div>
        </div>
    </div>

    <div class="p-6 border-t border-outline-variant bg-surface-container-low flex gap-3">
        <button id="btn-edit-user-from-drawer" class="flex-1 py-2.5 bg-primary text-on-primary rounded-md text-xs font-semibold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 shadow-sm">
            <span class="material-symbols-outlined text-sm">edit</span> Editar Usuario
        </button>
    </div>
</aside>

<!-- ========================================================= -->
<!-- MODAL: NOTIFICACIÓN DE ÉXITO                              -->
<!-- ========================================================= -->
@if(session('success'))
<div id="modal-exito" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-on-surface/40 backdrop-blur-overlay">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-sm p-6 shadow-ambient-lvl2 border border-outline-variant text-center space-y-4">
        <div class="w-12 h-12 rounded-full bg-primary/20 text-primary flex items-center justify-center mx-auto">
            <span class="material-symbols-outlined text-3xl">check_circle</span>
        </div>
        <div>
            <h3 id="modal-exito-titulo" class="text-lg font-bold text-on-surface">{{ session('title', '¡Operación Exitosa!') }}</h3>
            <p id="modal-exito-mensaje" class="text-xs text-on-surface-variant mt-1">{{ session('success') }}</p>
        </div>
        <button onclick="cerrarModalExito()" class="w-full py-2.5 rounded-md bg-primary text-on-primary text-xs font-semibold hover:bg-primary/90 transition-colors shadow-sm">
            Aceptar
        </button>
    </div>
</div>
@endif

@if(session('error'))
<div id="modal-error" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-on-surface/40 backdrop-blur-overlay">
    <div class="bg-surface-container-lowest rounded-modal w-full max-w-sm p-6 shadow-ambient-lvl2 border border-outline-variant text-center space-y-4">
        <div class="w-12 h-12 rounded-full bg-error-container/30 text-error flex items-center justify-center mx-auto">
            <span class="material-symbols-outlined text-3xl">error</span>
        </div>
        <div>
            <h3 class="text-lg font-bold text-on-surface">{{ session('title', 'Atención') }}</h3>
            <p class="text-xs text-on-surface-variant mt-1">{{ session('error') }}</p>
        </div>
        <button onclick="document.getElementById('modal-error').remove()" class="w-full py-2.5 rounded-md bg-error text-on-error text-xs font-semibold hover:bg-error/90 transition-colors shadow-sm">
            Aceptar
        </button>
    </div>
</div>
@endif

<script>
    const userBaseUrl = "{{ url('users') }}";

    function abrirModalCrearUsuario() {
        document.getElementById('modal-usuario-titulo').innerText = 'Registrar Nuevo Usuario';
        document.getElementById('form-usuario').action = userBaseUrl;
        document.getElementById('usuario-form-method').value = 'POST';
        document.getElementById('form-usuario').reset();
        
        document.getElementById('input-usuario-password').required = true;
        document.getElementById('label-password').innerText = 'Contraseña *';
        document.getElementById('help-password').classList.add('hidden');
        
        document.getElementById('btn-guardar-usuario').innerText = 'Guardar Usuario';

        document.getElementById('modal-usuario').classList.remove('hidden');
        document.getElementById('modal-usuario').classList.add('flex');
    }

    function abrirModalEditarUsuario(user) {
        document.getElementById('modal-usuario-titulo').innerText = `Editar Usuario: ${user.name}`;
        document.getElementById('form-usuario').action = `${userBaseUrl}/${user.id}`;
        document.getElementById('usuario-form-method').value = 'PUT';

        document.getElementById('input-usuario-name').value = user.name || '';
        document.getElementById('input-usuario-email').value = user.email || '';
        
        document.getElementById('input-usuario-password').value = '';
        document.getElementById('input-usuario-password').required = false;
        document.getElementById('label-password').innerText = 'Contraseña (Opcional)';
        document.getElementById('help-password').classList.remove('hidden');

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
        document.getElementById('detail-user-id').innerText = `#${user.id}`;
        document.getElementById('detail-user-name').innerText = user.name || 'Sin Nombre';
        document.getElementById('detail-user-email').innerText = user.email || '-';
        document.getElementById('detail-user-avatar').innerText = (user.name || 'US').substring(0, 2).toUpperCase();
        document.getElementById('detail-user-created').innerText = user.created_at ? user.created_at : '-';

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

    function cerrarModalExito() {
        const modal = document.getElementById('modal-exito');
        if (modal) modal.remove();
    }

    // Top search bar sync
    document.getElementById('top-search-input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const val = this.value;
            window.location.href = `{{ route('users.index') }}?buscar=${encodeURIComponent(val)}`;
        }
    });
</script>
@endsection
