<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resibo extends Model
{
    protected $table='resibos';

    protected $fillable=[
        'fecha',
        'total',
    ];
}
