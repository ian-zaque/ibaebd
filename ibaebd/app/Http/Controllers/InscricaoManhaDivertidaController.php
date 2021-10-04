<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\InscricaoManhaDivertida;

use Illuminate\Http\Request;

class InscricaoManhaDivertidaController extends Controller
{
    public function getInscricoesManhaDivertida(){
        $matriculas= InscricaoManhaDivertida::all();
        return response()->json($matriculas);
    }

    public function atualizar(Request $request){
        $dados = $request->all();
        $dados['contato'] = preg_replace('/[\s,.\-\/()-]+/', '', $dados['contato']);
        
        $msgsErros=[
            'required'=> 'É necessário preencher o campo :attribute',
            'string' => '',
            'min' => ' O valor mínimo para :attribute é 3',
            'max' => ' O valor máximo para :attribute é 12',
            'boolean' => 'Selecione um dos valores do campo :attribute'
        ];

        $atributos = [
            'nome'=> 'Nome da Criança', 'sobrenome'=>'Sobrenome da Criança',
            'idade' => 'Idade da Criança', 'nome_responsavel' => 'Responsável pela Criança', 
            'nome_pai' => 'Nome do Pai da Criança', 'nome_mae' => 'Nome da Mãe da Criança', 
            'banho_mangueira' => 'Banho de Mangueira?', 'contato' => 'Telefone de Contato',
        ];

        $validator = Validator::make($dados, [
            'nome' => 'string|required',
            'sobrenome' => 'string|required',
            'idade' => 'required|numeric|min:3|max:12', 
            'nome_responsavel' => 'string|nullable', 
            'nome_pai' => 'string|nullable',
            'nome_mae' => 'string|nullable',
            'banho_mangueira' => 'boolean|required', 
            'contato' => 'string|required',

        ],$msgsErros, $atributos);

        if ($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $dadosMat = [
                'nome'=>$dados['nome'], 'sobrenome'=>$dados['sobrenome'],
                'idade' =>$dados['idade'], 'nome_responsavel' => $dados['nome_responsavel'], 
                'nome_pai' =>$dados['nome_pai'], 'nome_mae' =>$dados['nome_mae'], 'banho_mangueira' =>$dados['banho_mangueira'], 'contato' =>$dados['contato'],    
            ];
            
            if($request->id){
                $matricula = InscricaoManhaDivertida::find($request->id);
                $matricula->update($dadosMat); $matricula->save();
            }
            else{
                $matricula = new InscricaoManhaDivertida(); 
                $matricula->fill($dadosMat); $matricula->save();
            }

        }
        return $this->getInscricoesManhaDivertida();

    }

    public function deletar($id){
        InscricaoManhaDivertida::find($id)->delete();
        return $this->getInscricoesManhaDivertida();
    }

}
