<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca; 

class MarcaController extends Controller
{
    public function index()
    {
        // Lógica para listar marcas
        return view('cadastro.marca');
    }

    public function store(Request $request){
        $marca = $request->input('marca');
        
        if( Marca::where('marca', $marca)->exists() ) {
            return redirect('cadastro')->with('error', 'Marca já cadastrada!');
        }

        Marca::create(['marca' => $marca]);
        return redirect('cadastro')->with('success', 'Marca cadastrada com sucesso!');
    }
}
