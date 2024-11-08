<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intere extends Model
{
    use HasFactory;
        // Campos que pueden ser llenados masivamente
        protected $fillable = [
            'nombre',
            'interes',
        ];
    public function prestamos()
{
    return $this->hasMany(Prestamo::class);
}

}
