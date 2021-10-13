<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Esposa;

class EsposaController extends Controller
{
    public function getEsposas(){
        $esposas= Esposa::all();
        return response()->json($esposas);
    }

    public function deletar($id){
        Esposa::find($id)->delete();
        return $this->getEsposas();
    }
}
