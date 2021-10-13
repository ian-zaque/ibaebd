<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Esposo;
use App\Esposa;

class Casal extends Model
{
    
    use SoftDeletes;

    protected $table = 'casals';

    protected $fillable = [
        'esposo_id', 'esposa_id', 'qntd_filhos', 'casamento', 'logradouro', 'cidade', 'num', 'bairro','cep','complemento',
    ];

    public function esposo(){
        return $this->hasOne('App\Esposo','id', 'esposo_id');
    }

    public function esposa(){
        return $this->hasOne('App\Esposa','id', 'esposa_id');
    }

}
