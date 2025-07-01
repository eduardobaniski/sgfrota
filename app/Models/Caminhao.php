<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caminhao extends Model
{
    //
    protected $fillable = [
        'marca',
        'modelo',
        'anoFabricacao',
        'placa',
        'renavam'
    ];
}
