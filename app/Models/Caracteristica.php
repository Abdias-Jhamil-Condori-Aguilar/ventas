<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
    public function tipo_documento(){
        return $this->hasOne(TipoDocumento::class);}

    public function categoria_producto()
{
    return $this->hasOne(CategoriaProducto::class);
}

}
