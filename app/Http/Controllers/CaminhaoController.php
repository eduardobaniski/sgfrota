<?php

namespace App\Http\Controllers;

use App\Models\Caminhao;
use Illuminate\Http\Request;

class CaminhaoController extends Controller
{
    public static function index()
    {
        // Aqui você pode buscar os caminhões do banco de dados
        return Caminhao::all();
    }
}
