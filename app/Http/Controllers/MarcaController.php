<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca; 

class MarcaController extends Controller
{
    public function index()
    {
        // Busca todas as marcas, ordenadas por nome
        $marcas = Marca::orderBy('nome')->paginate(10); // Usar paginate para listas longas

        // Retorna a view da tabela de gestão
        return view('admin.gerenciar.marca.index', ['marcas' => $marcas]);
    }

    public function create()
    {
        // Lógica para listar marcas
        return view('admin.cadastro.marca');
    }

    public function store(Request $request){
        $marca = $request->input('marca');
        
        if( Marca::whereRaw('LOWER(marca) = ?', [strtolower($marca)])->exists() ) {
            return redirect('gerenciar/marca')->with('error', 'Marca já cadastrada!');
        }

        Marca::create(['marca' => $marca]);
        return redirect('gerenciar/marca')->with('success', 'Marca cadastrada com sucesso!');
    }

     public function edit(Marca $marca)
    {
        return view('admin.gerenciar.marca.edit', ['marca' => $marca]);
    }

    public function update(Request $request, Marca $marca)
    {
        // Valida os dados recebidos do formulário de edição
        

        if (Marca::whereRaw('LOWER(marca) = ?', [strtolower($request->nome)])->exists()){
            return redirect()->route('admin.gerenciar.marca.index')->with('error', 'Marca já existe!');
        }

        // Atualiza a marca com os dados validados
        $marca->update(['marca' => $request->nome]);

        // Redireciona de volta para a lista de gestão com uma mensagem de sucesso
        return redirect()->route('admin.gerenciar.marca.index')->with('success', 'Marca atualizada com sucesso!');
    }

    public function destroy(Marca $marca)
    {
        $marca->delete();

        return redirect()->route('admin.gerenciar.marca.index')->with('success', 'Marca apagada com sucesso!');
    }
}
