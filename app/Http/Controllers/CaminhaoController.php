<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Caminhao;
use Illuminate\Http\Request;

class CaminhaoController extends Controller
{
    public static function all(){
        return Caminhao::all();
    }
    public function create()
    {
        // Busca todas as marcas para popular o primeiro dropdown do formulário
        $marcas = Marca::orderBy('nome')->get();
        

        // Retorna a view do formulário de registo
        return view('caminhoes.create', ['marcas' => $marcas]);
    }

    public function store(Request $request)
    {
        // Cria o caminhão no banco de dados
        Caminhao::create([
            //dados do caminhão
            'modelo_id' => $request->input('modelo_id'),
            'ano_fabricacao' => $request->input('ano_fabricacao'),
            'placa' => strtoupper($request->input('placa')),
            'renavam' => $request->input('renavam'),
            'status' => $request->input('status', 'Disponível'), // Valor padrão se não fornecido
        ]);

        // Redireciona para uma futura página de listagem com uma mensagem de sucesso
        // Por agora, vamos redirecionar de volta para o formulário de criação
        return redirect()->route('user.caminhoes.create')->with('success', 'Caminhão registado com sucesso!');
    }
    
}
