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
    ];

    // Um Caminhão pertence a um Modelo
    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }

    public function viagens()
    {
        return $this->hasMany(Viagem::class);
    }

     protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {
                // 1. A manutenção tem prioridade máxima
                if ($this->em_manutencao) {
                    return 'Em Manutenção';
                }

                // 2. Verifica se existe alguma viagem com data_fim nula
                $temViagemAtiva = $this->viagens()->whereNull('data_fim')->exists();

                if ($temViagemAtiva) {
                    return 'Em Trânsito';
                }

                // 3. Se nenhuma das condições acima for verdadeira, está disponível
                return 'Disponível';
            }
        );
    }
}
