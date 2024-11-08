<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    
    use HasFactory;

   
    // Nombre de la tabla
    protected $table = 'prestamos';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'cliente_id',
        'intere_id',
        'prenda_id',  // Cambiar 'prendas_id' a 'prenda_id'
        'fecha_inicio',
        'fecha_fin',
        'monto',
        'meses',  // Añadir 'meses' si lo vas a manejar
        'interes_calculado',
        'total_pagar',
        'estado',
    ];

    // Relación: Un préstamo pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación: Un préstamo está asociado a una prenda
    public function prenda()
    {
        return $this->belongsTo(Prenda::class, 'prendas_id');  // Cambiar 'prendas_id' a 'prenda_id'
    }

    // Relación: Un préstamo está asociado a un tipo de interés
    public function interes()
    {
        return $this->belongsTo(Intere::class, 'intere_id');
    }
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
