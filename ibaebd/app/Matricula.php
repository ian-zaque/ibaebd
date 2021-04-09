<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'matriculas';

    protected $fillable = [
        'nome', 'sobrenome', 'cpf', 'rg', 'orgao_emissor', 'uf', 'email', 'classe', 'nascimento', 'conversao',
        'isEvangelico', 'isMembro', 'sexo', 
    ];

    public function telefones(){
        return $this->hasOne('App\Telefone','id', 'matricula_id');
    }

    public function endereco(){
        return $this->hasOne('App\Endereco','id', 'matricula_id');
    }
}
