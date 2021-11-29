<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\CafeComunhao;

class CafeComunhaoController extends Controller
{
    public function getCafeComunhaos(){
        $esposas= CafeComunhao::all();
        return response()->json($esposas);
    }

    public function store(Request $request){
        $dados = $request->all();
        $dados['contato'] = preg_replace('/[\s,.\-\/()-]+/', '', $dados['contato']);
        
        $msgsErros=[
            'required'=> 'É necessário preencher o campo :attribute',
            'min' => ' O valor mínimo para :attribute é 0',
            'boolean' => 'Selecione um dos valores do campo :attribute'
        ];

        $atributos = [
            'nome'=> 'Nome', 'sobrenome'=>'Sobrenome',
            'qtd_participantes' => 'Qtd. de Participantes', 
            'doacoes' => 'Opção de Doação',
            'payment' => 'Forma de Doação', 
            'valor' => 'Valor da Doação',
            'contato' => 'Telefone de Contato'
        ];

        $validator = Validator::make($dados, [
            'nome' => 'required',
            'sobrenome' => 'required',
            'qtd_participantes' => 'required|numeric|min:0',
            'contato' => 'string|required',
            'payment' => 'boolean',
            'valor' => 'required|numeric|min:1',
            'doacoes' => 'required',
            'doacoes.*' => 'boolean',
        ],$msgsErros, $atributos);


        if ($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            if($request->id){    
                $dadosCafe = [
                    'nome'=> $dados['nome'], 'sobrenome'=> $dados['sobrenome'],
                    'qtd_participantes' => $dados['qtd_participantes'], 'doacoes' => $dados['doacoes'],
                    'payment' => $dados['payment'], 'valor' => $dados['valor'],
                    'contato' => $dados['contato'],
                ];

                $cafeComunhao = CafeComunhao::find($request->id); $cafeComunhao->update($dadosCafe); $cafeComunhao->save();
            }
            else{
                $dadosCafe = [
                    'nome'=> $dados['nome'], 'sobrenome'=> $dados['sobrenome'],
                    'qtd_participantes' => $dados['qtd_participantes'], 'doacoes' => $dados['doacoes'],
                    'payment' => $dados['payment'], 'valor' => $dados['valor'],
                    'contato' => $dados['contato'],
                ];

                $cafeComunhao = new CafeComunhao(); $cafeComunhao->fill($dadosCafe); $cafeComunhao->save();
            }
        }

        return $this->getCafeComunhaos();
    }

    public function deletar($id){
        CafeComunhao::find($id)->delete();
        return $this->getCafeComunhaos();
    }
}
