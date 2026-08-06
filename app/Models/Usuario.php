<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'Usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre_completo',
        'nombre_usuario',
        'contrasena',
        'rol',
        'correo',
        'estatus'
    ];

    protected $hidden = [
        'contrasena'
    ];
}
