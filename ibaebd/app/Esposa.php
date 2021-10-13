<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Esposa extends Model
{
    use SoftDeletes;

    protected $table = 'esposas';

    protected $fillable = [
        'nome', 'sobrenome', 'igreja', 'telefone', 'nascimento', 'membresia',
    ];

    public function esposo(){
        return $this->hasOneThrough('App\Esposo','App\Casal');
    }

}
