<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matricula extends Model
{
    use SoftDeletes;

    protected $table = 'matriculas';

    protected $fillable = [
        'nome', 'sobrenome', 'cpf', 'rg', 'orgao_emissor', 'uf', 'email', 'classe', 'nascimento', 'conversao',
        'isEvangelico', 'sexo', 'membresia',
    ];

    protected $casts=[
        'sexo' => 'boolean',
        'isEvangelico' => 'boolean',
    ];

    public function telefones(){ return $this->hasOne('App\Telefone', 'matricula_id'); }

    public function endereco(){ return $this->hasOne('App\Endereco', 'matricula_id'); }

}
