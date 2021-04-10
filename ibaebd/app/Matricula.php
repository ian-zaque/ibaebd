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
        return $this->hasOne('App\Telefone', 'matricula_id');
    }

    public function endereco(){
        return $this->hasOne('App\Endereco', 'matricula_id');
    }
}
