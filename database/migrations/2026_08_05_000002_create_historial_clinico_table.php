<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('HistorialClinico')) {
            Schema::create('HistorialClinico', function (Blueprint $table) {
                $table->integer('id_historial')->autoIncrement();
                $table->integer('id_animal');
                $table->enum('tipo_evento', ['vacuna', 'desparasitacion', 'tratamiento']);
                $table->string('nombre_producto', 100);
                $table->string('dosis', 30)->nullable();
                $table->date('fecha_aplicacion');
                $table->date('fecha_proxima_aplicacion')->nullable();
                $table->integer('id_usuario');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('HistorialClinico');
    }
};
