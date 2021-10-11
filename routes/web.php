<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JogadorController;
use App\Models\Jogador;

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
    return view('index');
});

Route::get('/jogador', function () {
    $jogadores = Jogador::orderBy('created_at', 'asc')->get();

    return view('jogador.list', [
        'jogadores' => $jogadores
    ]);
});

#Jogador
Route::get('/jogador/novo','App\Http\Controllers\JogadorController@create');//formulario adicionar
Route::post('/jogador/novo','App\Http\Controllers\JogadorController@store')->name('registrar_jogador');//exec adicionar
Route::get('/jogador/editar/{id}','App\Http\Controllers\JogadorController@edit');//exibir jogador
Route::put('/jogador/editar/{id}','App\Http\Controllers\JogadorController@update')->name('alterar_jogador');//atualizar jogador
Route::delete('/jogador/excluir/{id}','App\Http\Controllers\JogadorController@destroy')->name('excluir_jogador');//excluir jogador