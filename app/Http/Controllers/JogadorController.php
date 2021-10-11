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
        
        $valido = ((@$request->nome == "") || (@$request->nivel == "") ) ? false : true;
        $Jogador = new Jogador([
			'nome' => $request->nome,
            'nivel' => $request->nivel,
            'goleiro' => isset($request->goleiro) ? true : false
		]);

        if(!$valido){
            $erro = "O nome e nível do jogador devem ser informado para continuar";
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
        return view('jogador.edit',['Jogador' => $Jogador]);
    }

    /**
     * Executa o editar
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
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
            return Redirect::route('jogador')->with(['sucesso','O jogador foi excluído com sucesso.']);
        }else{
            return view("/jogador/editar/$id",['Jogador' => $Jogador,'erro' => 'Não foi possível excluir o jogador.']);
        }

    }
}
