<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    //
    protected $fillable = [
        'marca_id',
        'modelo'
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function caminhoes()
    {
        return $this->hasMany(Caminhao::class);
    }
}
