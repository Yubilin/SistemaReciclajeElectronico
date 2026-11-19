<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventario extends Model
{
    protected $table = 'inventarios';

    protected $fillable = [
        'cantidadDisponible',
        'cantidadMinima',
        'componente_id',
    ];

    public function componente(): BelongsTo
    {
        return $this->belongsTo(Componentes::class, 'componente_id');
    }
}
