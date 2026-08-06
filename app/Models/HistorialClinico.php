<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialClinico extends Model
{
    protected $table = 'HistorialClinico';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    protected $fillable = [
        'id_animal',
        'tipo_evento',
        'nombre_producto',
        'dosis',
        'fecha_aplicacion',
        'fecha_proxima_aplicacion',
        'id_usuario'
    ];

    public function animal()
    {
        return $this->belongsTo(Ganado::class, 'id_animal', 'id_animal');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
