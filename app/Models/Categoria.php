<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    //
    protected $fillable = [
        'nombre',
        'tipo',
    ];

    // Relacion muchos a uno con el modelo Movimiento
    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class);
    }
}
