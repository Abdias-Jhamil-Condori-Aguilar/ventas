<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{

    use HasFactory;

    protected $fillable = [
        'caracteristica_id',
    ];

    public function caracteristica(){

        return $this->belongsTo(Caracteristica::class);
    }
    public function clientes(){

        return $this->hasMany(Cliente::class);
    }
}
