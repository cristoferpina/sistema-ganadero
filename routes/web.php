<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GanadoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HistorialClinicoController;
use App\Http\Controllers\CicloReproductivoController;
use App\Http\Controllers\VentaController;

Route::get('/', [GanadoController::class, 'index'])->name('ganado.index');
Route::resource('ganado', GanadoController::class)->except(['create', 'edit']);
Route::resource('usuarios', UsuarioController::class)->except(['create', 'edit']);
Route::resource('historial-clinico', HistorialClinicoController::class)->except(['create', 'edit']);
Route::resource('ciclo-reproductivo', CicloReproductivoController::class)->except(['create', 'edit']);
Route::resource('ventas', VentaController::class)->except(['create', 'edit']);
