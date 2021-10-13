<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Esposo;

class EsposoController extends Controller
{
    public function getEsposos(){
        $esposas= Esposo::all();
        return response()->json($esposas);
    }

    public function deletar($id){
        Esposo::find($id)->delete();
        return $this->getEsposos();
    }
}
