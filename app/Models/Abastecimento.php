<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abastecimento extends Model
{
    use HasFactory;

    protected $table = 'abastecimentos';

    protected $fillable = [
        'caminhao_id',
        'motorista_id',
        'viagem_id',
        'city_id',
        'data',
        'odometro',
        'litros',
        'preco_por_litro',
        'valor_total',
        'observacoes',
    ];

    protected $casts = [
        'data' => 'datetime',
        'litros' => 'decimal:3',
        'preco_por_litro' => 'decimal:3',
        'valor_total' => 'decimal:2',
    ];

    // Relationships
    public function caminhao()
    {
        return $this->belongsTo(Caminhao::class);
    }

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

    public function viagem()
    {
        return $this->belongsTo(Viagem::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    // Scopes
    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['caminhao_id'])) {
            $query->where('caminhao_id', $filters['caminhao_id']);
        }
        if (!empty($filters['motorista_id'])) {
            $query->where('motorista_id', $filters['motorista_id']);
        }
        if (!empty($filters['viagem_id'])) {
            $query->where('viagem_id', $filters['viagem_id']);
        }
        if (!empty($filters['city_id'])) {
            $query->where('city_id', $filters['city_id']);
        }
        if (!empty($filters['data_inicio'])) {
            $query->whereDate('data', '>=', $filters['data_inicio']);
        }
        if (!empty($filters['data_fim'])) {
            $query->whereDate('data', '<=', $filters['data_fim']);
        }
        return $query;
    }
}