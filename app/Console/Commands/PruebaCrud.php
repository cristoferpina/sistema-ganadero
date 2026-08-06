<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Ganado;

class PruebaCrud extends Command
{
    // Este es el comando que escribiremos en la terminal para ejecutarlo
    protected $signature = 'crud:prueba';
    protected $description = 'Ejecuta operaciones CRUD y las muestra en consola';

    public function handle()
    {
        $this->info('--- INICIANDO PRUEBA CRUD DE BASE DE DATOS ---');

        // PREPARACIÓN: Crear un usuario para cumplir con la llave foránea
        $id_usuario = DB::table('Usuarios')->insertGetId([
            'nombre_completo' => 'Operador Consola',
            'nombre_usuario' => 'op_consola_' . rand(1, 1000),
            'contrasena' => bcrypt('12345'),
            'rol' => 'operador',
            'estatus' => 'activo'
        ]);

        // ==========================================
        // 1. CREATE: Crear 2 registros
        // ==========================================
        $this->info("\n1. CREATE: Insertando 2 registros nuevos...");
        Ganado::create([
            'arete' => 'MX-1001',
            'raza' => 'Angus',
            'sexo' => 'macho',
            'peso_actual' => 300.00,
            'categoria' => 'becerro',
            'estatus' => 'activo',
            'id_usuario_registro' => $id_usuario
        ]);

        $animal2 = Ganado::create([
            'arete' => 'MX-1002',
            'raza' => 'Hereford',
            'sexo' => 'hembra',
            'peso_actual' => 250.00,
            'categoria' => 'vaca',
            'estatus' => 'activo',
            'id_usuario_registro' => $id_usuario
        ]);
        $this->line('Registros MX-1001 y MX-1002 creados con éxito.');

        // ==========================================
        // 2. READ: Ver los registros
        // ==========================================
        $this->info("\n2. READ: Mostrando los registros actuales en la base de datos:");
        $registros = Ganado::whereIn('arete', ['MX-1001', 'MX-1002'])->get(['id_animal', 'arete', 'raza', 'peso_actual']);
        // Imprimimos una tabla visual en la consola
        $this->table(['ID', 'Arete', 'Raza', 'Peso Actual (kg)'], $registros);

        // ==========================================
        // 3. UPDATE: Editar el atributo del 2do registro y mostrar
        // ==========================================
        $this->info("\n3. UPDATE: Aumentando el peso del registro 2 (MX-1002)...");
        $animal2->peso_actual = 480.50; // Nuevo peso
        $animal2->save();

        $this->line('Cambio guardado. Así quedó el registro 2:');
        $registroActualizado = Ganado::where('arete', 'MX-1002')->get(['id_animal', 'arete', 'raza', 'peso_actual']);
        $this->table(['ID', 'Arete', 'Raza', 'Peso Actual (kg)'], $registroActualizado);

        // ==========================================
        // 4. DELETE: Eliminar el 2do registro y mostrar
        // ==========================================
        $this->info("\n4. DELETE: Eliminando el registro 2 (MX-1002)...");
        $animal2->delete();

        $this->line('Registro eliminado. Mostrando cómo quedó la tabla de Ganado (Solo debe quedar el 1):');
        $registrosFinales = Ganado::whereIn('arete', ['MX-1001', 'MX-1002'])->get(['id_animal', 'arete', 'raza', 'peso_actual']);
        $this->table(['ID', 'Arete', 'Raza', 'Peso Actual (kg)'], $registrosFinales);

        $this->info("\n--- PRUEBA FINALIZADA ---");
        $this->comment("Nota: El registro MX-1001 se quedó intacto para que puedas entrar a MariaDB y verlo con un SELECT.");
    }
}