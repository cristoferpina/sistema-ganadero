<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('Usuarios')) {
            Schema::create('Usuarios', function (Blueprint $table) {
                $table->integer('id_usuario')->autoIncrement();
                $table->string('nombre_completo', 100);
                $table->string('nombre_usuario', 50)->unique();
                $table->string('contrasena', 255);
                $table->enum('rol', ['administrador', 'operador']);
                $table->string('correo', 100)->nullable();
                $table->enum('estatus', ['activo', 'inactivo'])->default('activo');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('Usuarios');
    }
};
