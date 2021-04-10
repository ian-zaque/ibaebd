<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telefone extends Model
{
    use SoftDeletes;

    protected $table = 'telefones';

    protected $fillable = ['matricula_id','tel1', 'tel2'];

    public function matricula(){
        return $this->belongsTo('App\Matricula','matricula_id', 'id');
    }
}
