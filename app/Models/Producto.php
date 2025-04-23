<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table='producto';

    protected $fillable = [
        'nombre_producto',
        'precio_cliente',
        'precio_mayoreo',
        'descripcion_producto',
        'venta_producto',
    ];

    public function marcas(){
        return $this->belongsToMany(Marca::class, 'producto_marca')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
}
