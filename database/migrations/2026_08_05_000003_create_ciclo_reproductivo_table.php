<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('CicloReproductivo')) {
            Schema::create('CicloReproductivo', function (Blueprint $table) {
                $table->integer('id_ciclo')->autoIncrement();
                $table->integer('id_madre');
                $table->enum('tipo_monta', ['natural', 'inseminacion']);
                $table->date('fecha_monta');
                $table->date('fecha_parto_estimada')->nullable();
                $table->date('fecha_parto_real')->nullable();
                $table->integer('numero_crias')->nullable();
                $table->integer('id_cria')->nullable();
                $table->date('fecha_destete')->nullable();
                $table->integer('id_usuario_registro');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('CicloReproductivo');
    }
};
