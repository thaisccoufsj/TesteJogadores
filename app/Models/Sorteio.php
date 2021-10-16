<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sorteio extends Model{
    use HasFactory;

    protected $fillable = ["total_jogadores","total_times","data_jogo","hora_jogo"];
    protected $table = "sorteios";

}