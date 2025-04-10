<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    protected $table='recibos';

    protected $fillable=[
        'fecha',
        'total',
    ];
}
