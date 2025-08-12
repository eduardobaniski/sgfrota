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
        'cidadeOrigem',
        'cidadeDestino',
    ];

    public function caminhao()
    {
        return $this->belongsTo(Caminhao::class);
    }
    public function cidadeOrigem()
    {
        return $this->belongsTo(City::class, 'cidadeOrigem');
    }

    /**
     * Define o relacionamento: o Destino de uma Viagem é uma Cidade.
     */
    public function cidadeDestino()
    {
        return $this->belongsTo(City::class, 'cidadeDestino');
    }
}
