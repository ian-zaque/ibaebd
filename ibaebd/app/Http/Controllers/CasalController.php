<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Casal;
use App\Esposa;
use App\Esposo;

class CasalController extends Controller
{
    public function getCasais(){
        $casais = Casal::with(['esposo','esposa'])->get();
        return response()->json($casais);
    }

    public function atualizar(Request $request){
        $dados = $request->all();
        // dd($dados);
        $dados['esposo']['telefone'] = preg_replace('/[\s,.\-\/()-]+/', '', $dados['esposo']['telefone']);
        $dados['esposa']['telefone'] = preg_replace('/[\s,.\-\/()-]+/', '', $dados['esposa']['telefone']);


        $msgsErros=[
            'required'=> 'É necessário preencher o campo :attribute',
            'date' => 'O campo :attribute deve ser uma data válida',
        ];

        $atributos = [
            'esposo.nome'=> 'Nome do Esposo', 'esposo.sobrenome'=>'Sobrenome do Esposo', 'esposo.membresia'=> 'Membresia do Esposo',
            'esposo.nascimento'=>'Data de Nascimento do Esposo', 'esposo.telefone'=>'Telefone do Esposo', 'esposo.igreja' => 'Igreja do Esposo',

            'esposa.nome'=> 'Nome da Esposa', 'esposa.sobrenome'=>'Sobrenome da Esposa', 'esposa.membresia'=> 'Membresia da Esposa',
            'esposa.nascimento'=>'Data de Nascimento da Esposa', 'esposa.telefone'=>'Telefone da Esposa', 'esposa.igreja' => 'Igreja da Esposa',
            
            'qntd_filhos' => 'Qtd. de Filhos', 'casamento' => 'Data de Casamento',

            'logradouro'=>'Logradouro', 'cidade'=>'Cidade', 'bairro'=>'Bairro',
            'cep'=>'CEP', 'complemento'=>'Complemento', 'num'=>'Nº da Casa',
        ];

        $validator = Validator::make($dados, [
            'esposo.nome'=> 'string|required', 
            'esposo.sobrenome'=> 'string|required', 
            'esposo.membresia'=> 'required|in:m,c,s',
            'esposo.nascimento'=> 'bail|date|required', 
            'esposo.telefone'=> 'string|required', 
            'esposo.igreja' => 'string|required',

            'esposa.nome'=> 'string|required', 
            'esposa.sobrenome'=> 'string|required', 
            'esposa.membresia'=> 'required|in:m,c,s',
            'esposa.nascimento'=> 'bail|date|required', 
            'esposa.telefone'=> 'string|required', 
            'esposa.igreja' => 'string|required',

            'qntd_filhos' => 'required|numeric|min:0|max:100', 
            'casamento' => 'bail|date|required',

            'logradouro' => 'string|required',
            'cidade' => 'string|required',
            'bairro' => 'string|required',
            'cep' => 'string|nullable',
            'complemento' => 'string|nullable',
            'num' => 'string|required',
        ],$msgsErros, $atributos);

        if ($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            if($request->id){
                $esposo = Esposo::find($dados['esposo']['id']); $esposo->update($dados['esposo']); $esposo->save();
                $esposa = Esposa::find($dados['esposa']['id']); $esposa->update($dados['esposa']); $esposa->save();
                
                $dadosCasal = [
                    'esposo_id' => $esposo->id, 'esposa_id' => $esposa->id, 'logradouro' => $dados['logradouro'],
                    'cidade' => $dados['cidade'], 'bairro' => $dados['bairro'], 'cep' => $dados['cep'],
                    'complemento' => $dados['complemento'], 'num' => $dados['num'], 'qntd_filhos' => $dados['qntd_filhos'],
                    'casamento' => $dados['casamento'],
                ];
                $casal = Casal::find($dados['id']); $casal->update($dadosCasal); $casal->save();
                 
            }
            else{
                $esposo = new Esposo(); $esposo->fill($dados['esposo']); $esposo->save();
                $esposa = new Esposa(); $esposa->fill($dados['esposa']); $esposa->save();
                
                $dadosCasal = [
                    'esposo_id' => $esposo->id, 'esposa_id' => $esposa->id, 'logradouro' => $dados['logradouro'],
                    'cidade' => $dados['cidade'], 'bairro' => $dados['bairro'], 'cep' => $dados['cep'],
                    'complemento' => $dados['complemento'], 'num' => $dados['num'], 'qntd_filhos' => $dados['qntd_filhos'],
                    'casamento' => $dados['casamento'],
                ];
                $casal = new Casal(); $casal->fill($dadosCasal); $casal->save();
            }

        }
        return $this->getCasais();

    }

    public function deletar($id){
        Casal::find($id)->delete();
        return $this->getCasais();
    }

}
