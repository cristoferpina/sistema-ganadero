<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'Venta';
    protected $primaryKey = 'id_venta';
    public $timestamps = false;

    protected $fillable = [
        'id_animal',
        'tipo_movimiento',
        'fecha_movimiento',
        'contraparte',
        'precio',
        'id_usuario_registro'
    ];

    public function animal()
    {
        return $this->belongsTo(Ganado::class, 'id_animal', 'id_animal');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_registro', 'id_usuario');
    }
}
