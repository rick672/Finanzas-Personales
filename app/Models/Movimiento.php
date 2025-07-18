<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimiento extends Model
{
    //
    // En Movimiento.php
    protected $casts = [
        'fecha' => 'date',
    ];

    protected $fillable = [
        'user_id',
        'categoria_id',
        'tipo',
        'monto',
        'descripcion',
        'foto',
        'fecha',
    ];

    // Relacion muchos a uno con el modelo User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relacion muchos a uno con el modelo Categoria
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    protected static function booted(){
        static::creating(function($movimiento){
            if($movimiento->tipo === 'gasto'){
                $presupuesto = Presupuesto::where('user_id', $movimiento->user_id)
                    ->where('categoria_id', $movimiento->categoria_id)
                    ->where('mes', $movimiento->fecha->format('F'))
                    ->where('anio', now()->year)
                    ->first();
                if($presupuesto){
                    $presupuesto->monto_gastado += $movimiento->monto;
                    $presupuesto->save();
                }
            }
        });
    }
}
