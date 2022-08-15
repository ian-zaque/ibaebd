<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EbdMusicos extends Model
{
    use SoftDeletes;

    protected $table = 'ebd_musicos';

    protected $fillable = [
        'nome', 'sobrenome', 'nascimento', 'email', 'telefone', 'grupo_mma', 'tempo_mma', 'instrumento',
        'naipe_vocal', 'pgm', 'tempo_pgm', 'preferencia_horario', 'versiculo',
    ];

    protected $casts=[
        'instrumento' => 'array',
        'grupo_mma' => 'array',
    ];
}
