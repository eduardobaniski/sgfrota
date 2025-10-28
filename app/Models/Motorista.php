<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motorista extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nome',
        'cpf',
        'cnh',
        'cnh_validade',
        'telefone'
    ];

    protected $casts = [
        'cnh_validade' => 'date',
    ];

    public function viagens()
    {
        return $this->hasMany(Viagem::class);
    }
}
