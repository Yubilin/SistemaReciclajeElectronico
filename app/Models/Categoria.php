<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function materialesRecibidos(): HasMany
    {
        return $this->hasMany(MaterialRecibido::class, 'categoria_id');
    }
}
