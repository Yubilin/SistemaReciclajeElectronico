<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

class Asignacion extends Model
{
    private const MAX_ACTIVE_ASSIGNMENTS_PER_TECHNICIAN = 7;

    private const ACTIVE_STATES = ['Pendiente', 'En Progreso'];

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

    protected static function booted(): void
    {
        static::saving(function (Asignacion $asignacion): void {
            $isActive = in_array($asignacion->estado, self::ACTIVE_STATES, true);
            $wasActive = $asignacion->exists && in_array($asignacion->getOriginal('estado'), self::ACTIVE_STATES, true);
            $changesActiveLoad = ! $asignacion->exists || ! $wasActive || $asignacion->isDirty('usuario_id');

            if (! $isActive || ! $changesActiveLoad) {
                return;
            }

            $activeAssignments = self::query()
                ->where('usuario_id', $asignacion->usuario_id)
                ->whereIn('estado', self::ACTIVE_STATES);

            if ($asignacion->exists) {
                $activeAssignments->whereKeyNot($asignacion->getKey());
            }

            if ($activeAssignments->count() >= self::MAX_ACTIVE_ASSIGNMENTS_PER_TECHNICIAN) {
                throw ValidationException::withMessages([
                    'usuario_id' => 'Este técnico ya tiene 7 trabajos activos. Completa o reasigna uno antes de aceptar otro.',
                ]);
            }
        });
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function materialRecibido(): BelongsTo
    {
        return $this->belongsTo(MaterialRecibido::class, 'material_recibido_id');
    }
}
