<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Componentes extends Model
{
    protected $table = 'componentes';

    protected $fillable = [
        'nombre',
        'descripcion',
        'cantidad',
        'estado',
        'recuperacion_id',
    ];

    public function recuperacion(): BelongsTo
    {
        return $this->belongsTo(recuperacion::class, 'recuperacion_id');
    }

    public function inventario(): HasOne
    {
        return $this->hasOne(Inventario::class, 'componente_id');
    }
}
