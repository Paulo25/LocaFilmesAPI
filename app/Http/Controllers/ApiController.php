<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ApiController extends Controller
{
     /**
     * Trait de respostas com métodos comuns para todos os controladores filhos
     */
    use ApiResponser;
}
