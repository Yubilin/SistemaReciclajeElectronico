<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entregante extends Model
{
    protected $table = 'entregantes';
    protected $fillable = [
        'nombre',
        'apellido',
        'ci',
        'telefono',
        'direccion',
    ];
    public function recepciones(): HasMany
    {
        return $this->hasMany(Recepcion::class, 'entregante_id');
    }
}
