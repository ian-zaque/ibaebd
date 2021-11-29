<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CafeComunhao extends Model
{
    
    use SoftDeletes;

    protected $table = 'cafe_comunhaos';

    protected $fillable = [
        'nome', 'sobrenome', 'contato', 'qtd_participantes', 'payment', 'valor', 'doacoes',
    ];

    protected $casts=[
        'doacoes' => 'array',
        'payment' => 'boolean',
    ];

}
