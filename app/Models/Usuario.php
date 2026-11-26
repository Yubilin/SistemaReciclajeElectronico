<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasName;
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Authenticatable implements HasName
{
    use Notifiable, HasRoles;

    protected $table = 'usuarios';

    protected $authPasswordName = 'contraseña';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'contraseña',
        'rol',
        'estado',
    ];

    protected $hidden = [
        'contraseña',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'contraseña' => 'hashed',
        ];
    }

    public function getFilamentName(): string
    {
        return trim("{$this->nombre} {$this->apellido}") ?: $this->correo;
    }

    public function recepciones(): HasMany
    {
        return $this->hasMany(Recepcion::class, 'usuario_id');
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(Asignacion::class, 'usuario_id');
    }
}