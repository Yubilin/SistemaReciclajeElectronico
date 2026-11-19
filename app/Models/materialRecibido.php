<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class materialRecibido extends Model
{
    protected $table = 'material_recibidos';

    protected $fillable = [
        'nombre',
        'tipo',
        'marca',
        'modelo',
        'descripcion',
        'cantidad',
        'categoria_id',
        'recepcion_id',
    ];

    public function recepcion(): BelongsTo
    {
        return $this->belongsTo(Recepcion::class, 'recepcion_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(categoria::class, 'categoria_id');
    }

    public function recuperaciones(): HasMany
    {
        return $this->hasMany(recuperacion::class, 'material_recibido_id');
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(asignacion::class, 'material_recibido_id');
    }
}
