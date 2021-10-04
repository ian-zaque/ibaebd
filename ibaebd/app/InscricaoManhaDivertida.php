<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscricaoManhaDivertida extends Model
{
    use SoftDeletes;

    protected $table = 'inscricao_manha_divertidas';

    protected $fillable = [
        'nome', 'sobrenome', 'idade', 'nome_responsavel', 'nome_pai', 'nome_mae', 'banho_mangueira', 'contato',
    ];

    protected $casts=[
        'banho_mangueira' => 'boolean',
    ];

}
