<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    public function index()
    {
        $modelos = Modelo::with('marca')->orderBy('nome')->paginate(10);

        return view('admin.gerenciar.modelo.index', ['modelos' => $modelos]);
    }

    public function edit(Modelo $modelo)
    {
        // O Laravel já encontra o modelo pelo ID.
        // Também buscamos todas as marcas para popular o dropdown de seleção de marca.
        $marcas = Marca::orderBy('nome')->get();

        return view('admin.gerenciar.modelo.edit', [
            'modelo' => $modelo,
            'marcas' => $marcas
        ]);
    }

    public function update(Request $request, Modelo $modelo)
    {
        $dadosValidados = $request->validate([
            'nome' => 'required|string|max:255',
            'marca_id' => 'required|exists:marcas,id'
        ]);

        // Lógica opcional para verificar duplicatas antes de atualizar
        $duplicataExiste = Modelo::where('nome', $dadosValidados['nome'])
                                 ->where('marca_id', $dadosValidados['marca_id'])
                                 ->where('id', '!=', $modelo->id) // Ignora o próprio modelo
                                 ->exists();

        if ($duplicataExiste) {
            return back()->with('error', 'Este modelo já está registado para esta marca.');
        }

        $modelo->update($dadosValidados);

        return redirect()->route('admin.gerenciar.modelo.index')->with('success', 'Modelo atualizado com sucesso!');
    }

    public function destroy(Modelo $modelo)
    {
        $modelo->delete();
        
        return redirect()->route('admin.gerenciar.modelo.index')->with('success', 'Modelo apagado com sucesso!');
    }

    public function create()
    {
        $marcas = Marca::orderBy('marca')->pluck('marca', 'id');
        return view('admin.cadastro.modelo', ['marcas' => $marcas]);
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
