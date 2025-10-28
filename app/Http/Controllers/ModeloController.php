<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100], true) ? $perPage : 10;

        // Ordena alfabeticamente pelo nome do modelo e permite busca por modelo ou marca
        $modelos = Modelo::with('marca')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('modelo', 'like', "%{$q}%")
                        ->orWhereHas('marca', function ($qMarca) use ($q) {
                            $qMarca->where('marca', 'like', "%{$q}%");
                        });
                });
            })
            ->orderBy('modelo')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.gerenciar.modelo.index', [
            'modelos' => $modelos,
            'q' => $q,
            'perPage' => $perPage,
        ]);
    }

    public function edit(Modelo $modelo)
    {
        // O Laravel já encontra o modelo pelo ID.
        // Também buscamos todas as marcas para popular o dropdown de seleção de marca.
    // Corrige ordenação por coluna existente na tabela de marcas
    $marcas = Marca::orderBy('marca')->get();

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
        $duplicataExiste = Modelo::whereRaw('LOWER(modelo) = ?', [strtolower($request['nome'])])
                    ->where('marca_id', $request->input('marca_id'))
                    ->exists();;

        if ($duplicataExiste) {
            return redirect('gerenciar/modelo')->with('error', 'Este modelo já está registado para esta marca.');
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
        if(Modelo::whereRaw('LOWER(modelo) = ?', [strtolower($request->input('modelo'))])
                    ->where('marca_id', $request->input('marca_id'))
                    ->exists()){
            return redirect('gerenciar/modelo')->with('error', 'Este modelo já existe para esta marca!');
        }
        Modelo::create([
            'modelo' => $request['modelo'],
            'marca_id' => $request['marca_id'],
        ]);

        return redirect('gerenciar/modelo')->with('success', 'Modelo cadastrado com sucesso!');
    }
}
