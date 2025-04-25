<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    protected $table = 'credito';

    protected $fillable = [
        'monto_facturado',
        'interes_moratorio',
        'prima',
    ];
}
