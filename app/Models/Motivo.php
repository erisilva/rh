<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Motivo extends Model
{
    protected $fillable = [
        'descricao',
    ];

    public function pedidos() : HasMany
    {
        return $this->hasMany(Pedido::class);
    }
}
