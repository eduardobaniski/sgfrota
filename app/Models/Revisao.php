<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revisao extends Model
{
    //
    protected $fillable=[
        'odometro',
        'dataPlanejada',
        'descricao'
    ];
}
