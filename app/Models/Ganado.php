<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ganado extends Model
{
    protected $table = 'Ganado';
    protected $primaryKey = 'id_animal';
    public $timestamps = false;

    protected $fillable = [
        'arete',
        'nombre',
        'raza',
        'sexo',
        'fecha_nacimiento',
        'peso_actual',
        'categoria',
        'estatus',
        'id_madre',
        'id_usuario_registro'
    ];

    public function madre()
    {
        return $this->belongsTo(Ganado::class, 'id_madre', 'id_animal');
    }

    public function historialesClinicos()
    {
        return $this->hasMany(HistorialClinico::class, 'id_animal', 'id_animal');
    }

    public function ciclosReproductivos()
    {
        return $this->hasMany(CicloReproductivo::class, 'id_madre', 'id_animal');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_animal', 'id_animal');
    }
}