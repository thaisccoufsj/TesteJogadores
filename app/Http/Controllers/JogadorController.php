<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jogador;
use Illuminate\Support\Facades\Redirect;

class JogadorController extends Controller{
    /**
     * Lista jogadores
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('jogador.list');
    }

    /**
     * Formulário para adicionar
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view("jogador.create");
    }

    /**
     * Executa o adicionar
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        $Jogador = new Jogador([
			'nome' => $request->nome,
            'nivel' => $request->nivel,
            'goleiro' => isset($request->goleiro) ? true : false
		]);

        if(!$this->validarJogador($request)){
            $erro = "O nome e nível do jogador devem ser informados para continuar";
            return view('/jogador.create',['Jogador' => $Jogador,'erro' => $erro]);
        }

		$Jogador->save();
		return view('/jogador.edit',['Jogador' => $Jogador,'sucesso' => "O novo jogador foi salvo com sucesso."]);
    }

    /**
     * Formulário para editar
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $Jogador = Jogador::findOrFail($id);
        return view('jogador.edit',['Jogador' => $Jogador,'id' => $id]);
    }

    /**
     * Executa o editar
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        
        $Jogador_Atualizado = new \stdClass();
        $Jogador_Atualizado->id = $id;
        $Jogador_Atualizado->nome = $request->nome;
        $Jogador_Atualizado->nivel = $request->nivel;
        $Jogador_Atualizado->goleiro = isset($request->goleiro) ? true : false;
       
        if(!$this->validarJogador($request)){
            $erro = "O nome e nível do jogador devem ser informados para continuar";
            return view('/jogador.create',['Jogador' => $Jogador_Atualizado,'erro' => $erro]);
        }

        $Jogador = Jogador::find($id);

        if($Jogador->update([
            'nome' => $Jogador_Atualizado->nome,
            'nivel' => $Jogador_Atualizado->nivel,
            'goleiro' => $Jogador_Atualizado->goleiro
        ])){
            return view('/jogador.edit',['Jogador' => $Jogador_Atualizado,'sucesso' => "O jogador foi salvo com sucesso."]);
        }else{
            return view('/jogador.edit',['Jogador' => $Jogador_Atualizado,'erro' => "Não foi possível salvar o jogador."]);
        }

    }

    private function validarJogador($request){
        return ((@$request->nome == "") || (@$request->nivel == "") ) ? false : true;
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $Jogador = Jogador::findOrFail($id);
        $sucesso = $Jogador->delete();
        unset($Jogador);

        if($sucesso){
            return Redirect::route('listar_jogadores')->with(['sucesso','O jogador foi excluído com sucesso.']);
        }else{
            return view("/jogador/editar/$id",['Jogador' => $Jogador,'erro' => 'Não foi possível excluir o jogador.']);
        }

    }
}