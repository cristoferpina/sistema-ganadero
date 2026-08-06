<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CicloReproductivo extends Model
{
    protected $table = 'CicloReproductivo';
    protected $primaryKey = 'id_ciclo';
    public $timestamps = false;

    protected $fillable = [
        'id_madre',
        'tipo_monta',
        'fecha_monta',
        'fecha_parto_estimada',
        'fecha_parto_real',
        'numero_crias',
        'id_cria',
        'fecha_destete',
        'id_usuario_registro'
    ];

    public function madre()
    {
        return $this->belongsTo(Ganado::class, 'id_madre', 'id_animal');
    }

    public function cria()
    {
        return $this->belongsTo(Ganado::class, 'id_cria', 'id_animal');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_registro', 'id_usuario');
    }
}
