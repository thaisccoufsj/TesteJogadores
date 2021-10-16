<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
include app_path() . "/Funcoes/DataHora.php";

class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}