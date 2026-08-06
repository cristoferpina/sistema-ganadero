<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ganado;

class GanadoSeeder extends Seeder
{
    public function run(): void
    {
        Ganado::truncate();

        Ganado::create([
            'arete' => 'AR-001',
            'nombre' => 'Relámpago',
            'raza' => 'Angus',
            'sexo' => 'Macho',
            'fecha_nacimiento' => '2021-04-12',
            'peso_actual' => 850.00,
            'categoria' => 'Toro',
            'estatus' => 'Activo',
            'id_madre' => null,
            'id_usuario_registro' => 1,
        ]);

        Ganado::create([
            'arete' => 'AR-084',
            'nombre' => 'Estrella',
            'raza' => 'Holstein',
            'sexo' => 'Hembra',
            'fecha_nacimiento' => '2022-11-05',
            'peso_actual' => 520.00,
            'categoria' => 'Vaca',
            'estatus' => 'En Cuarentena',
            'id_madre' => null,
            'id_usuario_registro' => 1,
        ]);

        Ganado::create([
            'arete' => 'AR-112',
            'nombre' => 'Centella',
            'raza' => 'Brahman',
            'sexo' => 'Macho',
            'fecha_nacimiento' => '2024-02-18',
            'peso_actual' => 180.00,
            'categoria' => 'Ternero',
            'estatus' => 'Activo',
            'id_madre' => 1,
            'id_usuario_registro' => 1,
        ]);
    }
}
