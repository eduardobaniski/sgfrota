<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    public function index()
    {
        $marcas = Marca::orderBy('marca')->pluck('marca', 'id');
        return view('cadastro.modelo', ['marcas' => $marcas]);
    }

    public function store(Request $request){
        if(Modelo::where('modelo', $request['modelo'])
                         ->where('marca_id', $request['marca_id'])
                         ->exists()){
            return redirect('cadastro')->with('error', 'Este modelo já existe para esta marca!');
        }
        Modelo::create([
            'modelo' => $request['modelo'],
            'marca_id' => $request['marca_id'],
        ]);

        return redirect('cadastro')->with('success', 'Modelo cadastrado com sucesso!');
    }
}
