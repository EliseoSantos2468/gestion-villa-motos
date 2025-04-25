<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    protected $table = 'cliente';

    protected $fillable = [
        'nombres_cliente',
        'apellidos_cliente',
        'dui_cliente',
        'telefono_cliente',
        'nit_cliente',
        'email_cliente',
        'monto_max',
        'barrio',
        'id_clasificacion',
        'id_departamento',
        'id_municipio',
    ];
    
    public function clasificacion(){
        return $this->belongsTo(clasificacion::class);
    }

    public function departamento(){
        return $this->belongsTo(Departamento::class);
    }

    public function recibos(){
        return $this->hasMany(Recibo::class);
    }

    public function referencias(){
        return $this->belongsToMany(referencia::class, 'cliente_referencia')->withTimestamps();
    }

    public function productos(){
        return $this->belongsToMany(Producto::class, 'cliente_producto')
                                    ->withPivot('cantidad')
                                    ->withTimestamps();
    }
}
