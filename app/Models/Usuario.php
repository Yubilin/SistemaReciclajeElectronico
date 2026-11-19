<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'contraseña',
        'rol',
        'estado',
    ];

    public function recepciones(): HasMany
    {
        return $this->hasMany(Recepcion::class, 'usuario_id');
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(asignacion::class, 'usuario_id');
    }
}
