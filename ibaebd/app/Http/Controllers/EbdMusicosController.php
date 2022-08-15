<?php

namespace App\Http\Controllers;

use App\EbdMusicos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EbdMusicosController extends Controller
{
    public function getEbdMusicos(){
        $matriculas= EbdMusicos::all();
        return response()->json($matriculas);
    }

    public function atualizar(Request $request){
        $dados = $request->all();
        $dados['telefone'] = preg_replace('/[\s,.\-\/()-]+/', '', $dados['telefone']);
        
        $msgsErros=[
            'required'=> 'É necessário preencher o campo :attribute',
            'string' => '',
            'min' => 'O valor mínimo para :attribute é 0',
            'date' => 'O campo :attribute deve ser uma data válida',
            'in' => 'O campo :attribute deve ser uma opção válida'
        ];

        $atributos = [
            'nome'=> 'Nome', 'sobrenome'=>'Sobrenome',
            'nascimento' => 'Data de Nascimento', 'email' => 'Email', 'telefone' => 'Telefone', 
            'grupo_mma' => 'Grupo de Louvor', 'tempo_mma' => 'Tempo no(s) Grupo(s)', 'instrumento' => 'Instrumento(s)',
            'naipe_vocal' => 'Naipe Vocal', 'pgm' => 'PGM', 'tempo_pgm' => 'Tempo no PGM', 
            'preferencia_horario' => 'Preferência de Horário', 'versiculo' => 'Versículo',
        ];

        $validator = Validator::make($dados, [
            'nome' => 'string|required', 
            'sobrenome' => 'string|required', 
            'nascimento' => 'date|required',
            'email' => 'string|nullable|email:rfc,dns',
            'telefone'  => 'string|required', 
            'grupo_mma' => 'required', 
            'grupo_mma.*' => 'required|in:Adoradores,Cantares,Musicart,Provérbios 16,Salmodiadores', 
            'tempo_mma' => 'required|numeric|min:0',
            'instrumento' => 'nullable',
            'instrumento.*' => 'nullable|in:Piano,Teclado,Violão,Contrabaixo,Guitarra,Saxofone,Bateria,Percussão',
            'naipe_vocal' => 'string|nullable|in:Soprano,Contralto,Tenor,Barítono', 
            'pgm' => 'string|required', 
            'tempo_pgm' => 'required|numeric|min:0', 
            'preferencia_horario' => 'required|string|in:1,2,3', 
            'versiculo' => 'string|required',

        ],$msgsErros, $atributos);

        if ($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $dadosMat = [
                'nome' => $dados['nome'], 'sobrenome' => $dados['sobrenome'],
                'nascimento' => $dados['nascimento'], 'email' => $dados['email'], 'telefone' => $dados['telefone'], 
                'grupo_mma' => $dados['grupo_mma'], 'tempo_mma' => $dados['tempo_mma'], 'instrumento' => $dados['instrumento'],
                'naipe_vocal' => $dados['naipe_vocal'], 'pgm' => $dados['pgm'], 'tempo_pgm' => $dados['tempo_pgm'], 
                'preferencia_horario' => $dados['preferencia_horario'], 'versiculo' => $dados['versiculo'],    
            ];
            
            if($request->id){
                $matricula = EbdMusicos::find($request->id);
                $matricula->update($dadosMat); $matricula->save();
            }
            else{
                $matricula = new EbdMusicos();
                $matricula->fill($dadosMat); $matricula->save();
            }

        }
        return $this->getEbdMusicos();

    }

    public function deletar($id){
        EbdMusicos::find($id)->delete();
        return $this->getEbdMusicos();
    }
}
