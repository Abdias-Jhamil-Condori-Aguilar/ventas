<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    public function prestamos(){
        return $this->hasMany(Prestamo::class);
    }
    public function tipo_documento()
{
    return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
}

    protected $fillable = [
        'nombre',
        'papellido',
        'sapellido',
        'fecha_nacimiento',
        'correo_electronico',
        'telefono',
        'domicilio',
        'ciudad',
        'tipo_documento_id',
        'numero_identificacion',
    ];

}
