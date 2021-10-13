<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Esposo extends Model
{
    use SoftDeletes;

    protected $table = 'esposos';

    protected $fillable = [
        'nome', 'sobrenome', 'igreja', 'telefone', 'nascimento', 'membresia',
    ];

    public function esposa(){
        return $this->hasOneThrough('App\Esposa','App\Casal');
    }

}
