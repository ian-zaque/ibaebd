<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Matricula;
use App\Telefone;
use App\Endereco;

class MatriculaController extends Controller
{

    public function getMatriculas(){
        $matriculas= Matricula::with(['telefones', 'endereco'])->get();
        return response()->json($matriculas);
    }

    public function deletar($id){
        Endereco::where('matricula_id','=',$id)->delete();
        Telefone::where('matricula_id','=',$id)->delete();
        Matricula::find($id)->delete();
        return $this->getMatriculas();
    }

    public function atualizar(Request $request){

        $dados = $request->all();
        $dados['telefones']['tel1'] = preg_replace('/[\s,.\-\/()-]+/', '', $dados['telefones']['tel1']);
        $dados['telefones']['tel2'] = preg_replace('/[\s,.\-\/()-]+/', '', $dados['telefones']['tel2']);
        $dados['endereco']['cep'] = preg_replace('/[\s,.\-\/-]+/', '', $dados['endereco']['cep']);
        $dados['cpf'] = preg_replace('/[\s,.\-\/-]+/', '', $dados['cpf']);
        $dados['rg'] = preg_replace('/[\s,.\-\/-]+/', '', $dados['rg']);

        $msgsErros=[
            'required'=> 'É necessário preencher o campo :attribute',
            'string' => '',
            'email' => ' O campo :attribute é inválido',
            'date' => 'O campo :attribute deve ser uma data',
            'boolean' => 'Selecione um dos valores do campo :attribute'
        ];

        $atributos = [
            'nome'=> 'Nome', 'sobrenome'=>'Sobrenome', 'cpf'=>'CPF', 'rg'=>'RG', 'orgao_emissor'=>'Órgão Emissor',
            'uf'=>'UF','classe'=>'Classe','email'=>'E-mail','nascimento'=>'Data de Nascimento', 'conversao'=>'Data de Conversão',
            'sexo'=>'Sexo', 'isMembro'=>'Sou Membro da IBA!', 'isEvangelico'=>'Sou Evangélico', 'telefones.tel1'=>'Telefone 1',
            'telefones.tel2'=>'Telefone 2', 'endereco.logradouro'=>'Logradouro', 'endereco.cidade'=>'Cidade', 'endereco.bairro'=>'Bairro',
            'endereco.cep'=>'CEP', 'endereco.complemento'=>'Complemento', 'endereco.num'=>'Nº da Casa',
        ];

        $validator = Validator::make($dados, [
            'nome' => 'string|required',
            'sobrenome' => 'string|required',
            'cpf'=> 'string|required|',
            'rg' => 'string|required|',
            'orgao_emissor' => 'string|required|',
            'uf' => 'string|required',
            'classe' => 'string|required',
            'email' => 'string|required|email:rfc,dns',
            'nascimento' => 'date|required',
            'conversao' => 'date|nullable',
            'sexo' => 'boolean|required',
            'isMembro' => 'boolean|required',
            'isEvangelico' => 'boolean|required',

            'telefones.tel1' => 'string|required',
            'telefones.tel2' => 'string|nullable',

            'endereco.logradouro' =>' string|required',
            'endereco.cidade' =>' string|required',
            'endereco.bairro' =>' string|required',
            'endereco.cep' =>' string|required',
            'endereco.complemento' =>' string|required',
            'endereco.num' =>' string|required',
        ],$msgsErros, $atributos);

        if ($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $dadosMat = [
                'nome'=>$dados['nome'], 'sobrenome'=>$dados['sobrenome'], 'cpf'=>$dados['cpf'], 'rg'=>$dados['rg'],
                'orgao_emissor'=>$dados['orgao_emissor'], 'uf'=>$dados['uf'], 'classe'=>$dados['classe'],
                'email'=>$dados['email'], 'nascimento'=>$dados['nascimento'], 'conversao'=>$dados['conversao'],
                'sexo'=>$dados['sexo'], 'isMembro'=>$dados['isMembro'], 'isEvangelico'=>$dados['isEvangelico'],
            ];
            if($request->id){
                $matricula = Matricula::find($request->id); $matricula->fill($dadosMat); $matricula->save();

                $dadosTel = ['tel1'=>$dados['telefones']['tel1'], 'tel2'=>$dados['telefones']['tel2'],'matricula_id'=>$matricula->id];
                $telefones = Telefone::where('matricula_id','=',$matricula->id)->first(); 
                $telefones->fill($dadosTel); $telefones->save();
                
                $dadosEndereco = [
                    'logradouro'=> $dados['endereco']['logradouro'], 'cep'=>$dados['endereco']['cep'], 
                    'bairro'=> $dados['endereco']['bairro'], 'cidade'=>$dados['endereco']['cidade'],
                    'num' =>$dados['endereco']['num'], 'complemento'=>$dados['endereco']['complemento'],
                    'matricula_id'=>$matricula->id,
                ];
                $endereco = Endereco::where('matricula_id','=',$matricula->id)->first(); 
                $endereco->fill($dadosEndereco); $endereco->save();
            }
            else{
                $matricula = new Matricula(); $matricula->fill($dadosMat); $matricula->save();

                $dadosTel = ['tel1'=>$dados['telefones']['tel1'], 'tel2'=>$dados['telefones']['tel2'],'matricula_id'=>$matricula->id];
                $telefones = new Telefone(); 
                $telefones->fill($dadosTel); $telefones->save();

                $dadosEndereco = [
                    'logradouro'=> $dados['endereco']['logradouro'], 'cep'=>$dados['endereco']['cep'], 
                    'bairro'=> $dados['endereco']['bairro'], 'cidade'=>$dados['endereco']['cidade'],
                    'num' =>$dados['endereco']['num'], 'complemento'=>$dados['endereco']['complemento'],
                    'matricula_id'=>$matricula->id,
                ];
                $endereco = new Endereco(); 
                $endereco->fill($dadosEndereco); $endereco->save();
            }
        }
        return $this->getMatriculas();
    }
    
}
