<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SorteioJogadores extends Model{
    use HasFactory;

    protected $fillable = ["sorteio","time","jogador"];
    protected $table = "sorteio_jogadores";

}