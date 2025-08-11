<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Viagem extends Model
{
    protected $table = 'viagens';
    
    protected $fillable = [
        'caminhao_id',
        'odometroInicio',
        'odometroFinal',
        'dataInicio',
        'dataFim',
    ];

    public function caminhao()
    {
        return $this->belongsTo(Caminhao::class);
    }
}
