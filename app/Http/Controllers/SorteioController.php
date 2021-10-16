<?php

namespace App\Http\Controllers;

use App\Models\Jogador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Sorteio;
use App\Models\SorteioJogadores;
use Dflydev\DotAccessData\Data;
use stdClass;


class SorteioController extends Controller{

    private $Objeto;

    public function __construct(){
        $this->Objeto = new stdClass();
    }

    /**
     * Lista jogadores
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('sorteio.list');
    }

    /**
     * Formulário para adicionar
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view("sorteio.create");
    }

    /**
     * Executa o adicionar
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        $Sorteio = new Sorteio([
			'total_jogadores' => $request->total_jogadores,
            'total_times' => 0,
            'data_jogo' => $request->data_jogo,
            'hora_jogo' => $request->hora_jogo
		]);

        
        $msg = $this->validar($request);
     
        if($msg != ""){
            return view('/sorteio.create',['Sorteio' => $Sorteio,
                        'Jogadores_Selecionados' => isset($this->Objeto->listaJogadores) ? $this->Objeto->listaJogadores : Array(),
                        'erro' => $msg,
                        'Jogadores' => Jogador::all()]);
        }

        #Coloca no formato US apenas para salvar
        $Sorteio->data_jogo = DataBR2US($Sorteio->data_jogo);
		$Sorteio->save();

        $this->salvarJogadoresDoSorteio($Sorteio);

        $Sorteio->update(['total_times' => count($this->Objeto->times)]);
        
		return view('/sorteio.edit',
                    [
                        'Sorteio' => $Sorteio,
                        'Jogadores_Selecionados' => $this->Objeto->listaJogadores,
                        'Jogadores' => Jogador::all(),
                        'Times' => $this->Objeto->times,
                        'sucesso' => "O novo sorteio foi salvo com sucesso."
                    ]);
    }

    private function montarTimes($Jogadores_Selecionados){
        $this->Objeto->times = Array();
       
        foreach($Jogadores_Selecionados as $index=>$SorteioJogador){
        
            if(!array_key_exists($SorteioJogador["time"],$this->Objeto->times)){
                $this->Objeto->times[$SorteioJogador["time"]] = new stdClass();
                $this->Objeto->times[$SorteioJogador["time"]]->jogadores = Array();
                $this->Objeto->times[$SorteioJogador["time"]]->forca = 0;
            }

            $Jogador = Jogador::find($SorteioJogador["jogador"]);
            array_push($this->Objeto->times[$SorteioJogador["time"]]->jogadores,$Jogador);
            $this->Objeto->times[$SorteioJogador["time"]]->forca += $Jogador->nivel;

        }

    }

    private function sortearTimes($Sorteio){

        $this->Objeto->times = Array();
        $times = ceil(count($this->Objeto->listaJogadores)/$Sorteio->total_jogadores);

        #Inicia array de times
        for($i=0;$i<$times;$i++){
            $this->Objeto->times[$i] = new stdClass();
            $this->Objeto->times[$i]->jogadores = Array();
            $this->Objeto->times[$i]->forca = 0;
        }

        $jogadoresLinha = Array();
        $time = 0;

        #Cria vetor somente com atacantes e ja distribui os goleiros
        foreach($this->Objeto->listaJogadores as $Jogador){
            if(!$Jogador->goleiro){
                array_push($jogadoresLinha,$Jogador);
            }else{
                array_push($this->Objeto->times[$time]->jogadores,$Jogador);
                $this->Objeto->times[$time]->forca += $Jogador->nivel;
                $this->Objeto->listaJogadores[$Jogador->id]->time = $time;
                $time++;
            }
        }

        #Ordena pelos valores maiores primeiro
        usort($jogadoresLinha,function ($a, $b){
            return $a->nivel < $b->nivel;
        });
      
        #Distribui jogadores restantes
       foreach($jogadoresLinha as $Jogador){
            
            if(!array_key_exists($time,$this->Objeto->times)) $time = 0;

            $time = 0;
            $menorForca = $this->Objeto->times[0]->forca;

            foreach($this->Objeto->times as $idTime=>$Time){
                if(($Time->forca < $menorForca) && (count($this->Objeto->times[$idTime]->jogadores) < $Sorteio->total_jogadores)){
                    $menorForca = $Time->forca;
                    $time = $idTime;
                }
            }

            $this->Objeto->listaJogadores[$Jogador->id]->time = $time;
            $this->Objeto->times[$time]->forca += $Jogador->nivel;
            array_push($this->Objeto->times[$time]->jogadores,$Jogador);

        }

        while(true){
            
            $repetir = false;
            $ultimoIndex = max(array_keys($this->Objeto->times));

            for($i=0;$i<$ultimoIndex;$i++){
                $Time = $this->Objeto->times[$i];
                if(count($Time->jogadores) < $Sorteio->total_jogadores){
                    $repetir = true;
                    $Jogador = array_pop($this->Objeto->times[$ultimoIndex]->jogadores);
                    array_push($this->Objeto->times[$i]->jogadores,$Jogador);
                }
            }

            if(!$repetir) break;
        }
        
    }

    private function validar($request){

        if (($request->total_jogadores == "") || (!validarData(DataBR2US($request->data_jogo))) && (!validarHora($request->hora_jogo))){
            return "Todos os campos devem ser informados para continuar";
        }

        $this->calcularJogadoresSelecionados($request);
        $times = ceil(count($this->Objeto->listaJogadores)/$request->total_jogadores);

        if(count($this->Objeto->listaJogadores) < (2 * ($request->total_jogadores))){
            return "Número de jogadores baixo, não é possível completar dois times.";
        }

        if($this->Objeto->goleirosSelecionados != $times){
            return "Selecione " . $times . " goleiros (1 para cada time).";
        }

    }

    private function calcularJogadoresSelecionados($request){

        $this->Objeto->listaJogadores = Array();
        $this->Objeto->goleirosSelecionados = 0;
        
        $data = $request->all();

        if(!isset($data["jogador"])) return;
        
        foreach($data["jogador"] as $idJogador){
     
            $Jogador = Jogador::findOrFail($idJogador);
            
            if($Jogador->goleiro){
                $this->Objeto->goleirosSelecionados++;
            }
            
            $this->Objeto->listaJogadores[$idJogador] = $Jogador;
        
        }

    }

    /**
     * Formulário para editar
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $Sorteio = Sorteio::findOrFail($id);
        $Jogadores = Jogador::all();
        $Jogadores_Selecionados = SorteioJogadores::where("sorteio",'=',$id)->get()->toArray();
        $this->montarTimes($Jogadores_Selecionados);
        return view('sorteio.edit',[
                    'Sorteio' => $Sorteio,
                    'Jogadores' => $Jogadores,
                    'Times' => $this->Objeto->times,
                    'Jogadores_Selecionados' => $Jogadores_Selecionados]);
    }

    /**
     * Executa o editar
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $Sorteio_Atualizado = new \stdClass();
        $Sorteio_Atualizado->id = $id;
        $Sorteio_Atualizado->total_jogadores = $request->total_jogadores;
        $Sorteio_Atualizado->data_jogo = $request->data_jogo;
        $Sorteio_Atualizado->hora_jogo = $request->hora_jogo;

        $msg = $this->validar($request);
     
        if($msg != ""){
            $this->montarTimes(SorteioJogadores::where("sorteio",'=',$id)->get()->toArray());
            return view('/sorteio.edit',[
                        'Sorteio' => $Sorteio_Atualizado,
                        'Jogadores_Selecionados' => $this->Objeto->listaJogadores,
                        'erro' => $msg,
                        'Jogadores' => Jogador::all(),
                        'Times' => $this->Objeto->times]);
        }

        $Sorteio = Sorteio::find($id);
        $this->salvarJogadoresDoSorteio($Sorteio);

        if($Sorteio->update([
            'total_jogadores' => $Sorteio_Atualizado->total_jogadores,
            'data_jogo' => DataBR2US($Sorteio_Atualizado->data_jogo),
            'hora_jogo' => $Sorteio_Atualizado->hora_jogo,
            'total_times' => count($this->Objeto->times)
        ])){
            
            return view('/sorteio.edit',
                    [
                        'Sorteio' => $Sorteio_Atualizado,
                        'Jogadores_Selecionados' => $this->Objeto->listaJogadores,
                        'Jogadores' => Jogador::all(),
                        'Times' => $this->Objeto->times,
                        'sucesso' => "O sorteio foi salvo com sucesso."
                    ]);
        }else{
             return view('/sorteio.edit',
                    [
                        'Sorteio' => $Sorteio_Atualizado,
                        'Jogadores_Selecionados' => $this->Objeto->listaJogadores,
                        'Times' => $this->Objeto->times,
                        'Jogadores' => Jogador::all(),
                        'erro' => "Não foi possível salvar os dados sorteio."
                    ]);
        }
    }

    private function salvarJogadoresDoSorteio($Sorteio){

        $this->sortearTimes($Sorteio);
        $this->Objeto->SorteioJogadores = Array();

        SorteioJogadores::where("sorteio",'=',$Sorteio->id)->delete();

        foreach($this->Objeto->times as $idTime=>$Jogador){
            foreach($this->Objeto->times[$idTime]->jogadores as $Jogador){
                $Sorteio_Jogadores = new SorteioJogadores([
                    'sorteio' => $Sorteio->id,
                    'jogador' => $Jogador->id,
                    'time'    => $idTime
                ]);
    
                $Sorteio_Jogadores->save();

            }
        }
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $Sorteio = Sorteio::findOrFail($id);
        $sucesso = $Sorteio->delete();

        if($sucesso){
            unset($Sorteio);
            return Redirect::route('listar_sorteios')->with(['sucesso','O sorteio foi excluído com sucesso.']);
        }else{
            return view("/sorteio/editar/$id",['Sorteio' => $Sorteio,'erro' => 'Não foi possível excluir o sorteio.']);
        }

    }
}