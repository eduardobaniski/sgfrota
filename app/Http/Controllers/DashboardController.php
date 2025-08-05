<?php

namespace App\Http\Controllers;

use App\Models\Caminhao;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard', ['caminhoes' => Caminhao::all()]);
    }
}
