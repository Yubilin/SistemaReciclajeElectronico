<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function materialesRecibidos(): HasMany
    {
        return $this->hasMany(materialRecibido::class, 'categoria_id');
    }
}
