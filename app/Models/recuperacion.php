<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class recuperacion extends Model
{
    protected $table = 'recuperacions';

    protected $fillable = [
        'fecha',
        'observaciones',
        'resultado',
        'material_recibido_id',
    ];

    public function materialRecibido(): BelongsTo
    {
        return $this->belongsTo(materialRecibido::class, 'material_recibido_id');
    }

    public function componentes(): HasMany
    {
        return $this->hasMany(Componentes::class, 'recuperacion_id');
    }
}
