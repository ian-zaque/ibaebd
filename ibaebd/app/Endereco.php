<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'enderecos';

    protected $fillable = ['matricula_id','logradouro', 'cidade', 'num', 'bairro','cep','complemento'];

    public function matricula(){
        return $this->belongsTo('App\Matricula','matricula_id', 'id');
    }
}
