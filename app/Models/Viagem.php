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
    public function origem()
    {
        return $this->belongsTo(City::class, 'cidadeOrigem', 'id');
    }

    /**
     * Define o relacionamento: o Destino de uma Viagem é uma Cidade.
     */
    public function destino()
    {
        return $this->belongsTo(City::class, 'cidadeDestino', 'id');
    }
    
    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }
}
