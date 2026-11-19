<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class asignacion extends Model
{
    protected $table = 'asignacions';

    protected $fillable = [
        'numeroTurno',
        'fechaInicio',
        'fechaFinalizacion',
        'prioridad',
        'estado',
        'observacion',
        'usuario_id',
        'material_recibido_id',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function materialRecibido(): BelongsTo
    {
        return $this->belongsTo(materialRecibido::class, 'material_recibido_id');
    }
}
