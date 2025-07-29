<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    //
    protected $fillable = [
        'marca',
        'modelo'
    ];

     public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }
}
