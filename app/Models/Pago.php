<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $fillable = [
        'prestamo_id',
        'monto_pagado',
        'fecha_pago',
        'pagado',
        'user_id'
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
