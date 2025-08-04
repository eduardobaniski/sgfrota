<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caminhao extends Model
{
    //
    protected $table = 'caminhoes';
    protected $fillable = [
        'modelo_id',
        'ano_fabricacao',
        'placa',
        'renavam',
        'status',
    ];

    // Um Caminhão pertence a um Modelo
    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }
}
