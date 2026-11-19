<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recepcion extends Model
{
    protected $table = 'recepcions';

    protected $fillable = [
        'fecha',
        'observaciones',
        'estado',
        'usuario_id',
        'entregante_id',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function entregante(): BelongsTo
    {
        return $this->belongsTo(Entregante::class, 'entregante_id');
    }

    public function materialesRecibidos(): HasMany
    {
        return $this->hasMany(materialRecibido::class, 'recepcion_id');
    }
}
