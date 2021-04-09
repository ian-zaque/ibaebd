<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    protected $table = 'telefones';

    protected $fillable = ['matricula_id','tel1', 'tel2'];

    public function matricula(){
        return $this->belongsTo('App\Matricula','matricula_id', 'id');
    }
}
