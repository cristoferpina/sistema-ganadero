<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('Venta')) {
            Schema::create('Venta', function (Blueprint $table) {
                $table->integer('id_venta')->autoIncrement();
                $table->integer('id_animal');
                $table->enum('tipo_movimiento', ['venta', 'compra', 'muerte', 'baja']);
                $table->date('fecha_movimiento');
                $table->string('contraparte', 100)->nullable();
                $table->decimal('precio', 10, 2)->nullable();
                $table->integer('id_usuario_registro');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('Venta');
    }
};
