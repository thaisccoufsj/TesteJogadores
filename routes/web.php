<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JogadorController;
use App\Models\Jogador;
use App\Models\Sorteio;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $Sorteios = Sorteio::orderBy('created_at', 'asc')->get();

    return view('sorteio.list', [
        'Sorteios' => $Sorteios
    ]);
})->name("listar_sorteios");

Route::get('/jogador', function () {
    $jogadores = Jogador::orderBy('created_at', 'asc')->get();

    return view('jogador.list', [
        'jogadores' => $jogadores
    ]);
})->name("listar_jogadores");

#Jogador
Route::get('/jogador/novo','App\Http\Controllers\JogadorController@create');//formulario adicionar
Route::post('/jogador/novo','App\Http\Controllers\JogadorController@store')->name('registrar_jogador');//exec adicionar
Route::get('/jogador/editar/{id}','App\Http\Controllers\JogadorController@edit');//exibir jogador
Route::patch('/jogador/editar/{id}','App\Http\Controllers\JogadorController@update');//exec salvar
Route::delete('/jogador/excluir/{id}','App\Http\Controllers\JogadorController@destroy')->name('excluir_jogador');//exec excluir

#Sorteio
Route::get('/sorteio/novo',function(){
    $Jogadores = Jogador::all();
    return view('sorteio.create',[
        'Jogadores' => $Jogadores
    ]);
});

Route::get('/sorteio/editar/{id}','App\Http\Controllers\SorteioController@edit');

Route::post('/sorteio/novo','App\Http\Controllers\SorteioController@store')->name('registrar_sorteio');//exec adicionar

Route::patch('/sorteio/editar/{id}','App\Http\Controllers\SorteioController@update');//exec salvar
Route::delete('/sorteio/excluir/{id}','App\Http\Controllers\SorteioController@destroy')->name('excluir_sorteio');//exec excluir
