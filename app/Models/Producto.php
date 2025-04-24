<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table='producto';

    protected $fillable = [
        'nombre_producto',
        'descripcion_producto',
    ];

    public function marcas(){
        return $this->belongsToMany(Marca::class, 'producto_recibo', 'id_producto', 'id_recibo')
                    ->withPivot('cantidad')
                    ->withPivot('precio_cliente')
                    ->withPivot('precio_mayoreo')
                    ->withPivot('venta_producto')
                    ->withTimestamps();
    }

    public function recibos(){
        return $this->belongsToMany(Recibo::class, 'producto_recibo')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
}
