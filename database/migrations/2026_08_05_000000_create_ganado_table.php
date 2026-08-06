<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Ganado', function (Blueprint $table) {
            $table->id('id_animal');
            $table->string('arete')->unique();
            $table->string('nombre')->nullable();
            $table->string('raza');
            $table->enum('sexo', ['Macho', 'Hembra']);
            $table->date('fecha_nacimiento')->nullable();
            $table->decimal('peso_actual', 8, 2)->default(0);
            $table->string('categoria'); // Ternero, Novillo, Vaca, Toro
            $table->string('estatus')->default('Activo'); // Activo, En Cuarentena, Vendido, Fallecido
            $table->unsignedBigInteger('id_madre')->nullable();
            $table->unsignedBigInteger('id_usuario_registro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Ganado');
    }
};
