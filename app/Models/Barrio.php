<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barrio extends Model
{
    protected $table="barrio";

    protected $fillable = [
        'nombre_barrio',
        'municipio_id'
    ];
}
