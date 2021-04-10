<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{
    use SoftDeletes;

    protected $table = 'enderecos';

    protected $fillable = ['matricula_id','logradouro', 'cidade', 'num', 'bairro','cep','complemento'];

    public function matricula(){
        return $this->belongsTo('App\Matricula','matricula_id', 'id');
    }
}
