<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    public function index()
    {
        $modelos = Modelo::with('marca')
            ->orderBy('modelo')
            ->paginate(10);

        return view('admin.gerenciar.modelo.index', ['modelos' => $modelos]);
    }

    public function edit(Modelo $modelo)
    {
        $marcas = Marca::orderBy('nome')->get();
        return view('admin.gerenciar.modelo.edit', compact('modelo', 'marcas'));
    }

    public function update(Request $request, Modelo $modelo)
    {
        $request->validate([
            'marca_id' => 'required|exists:marcas,id',
        ]);

        $nomeNormalizado = $request->input('nome', $request->input('modelo'));
        if (!is_string($nomeNormalizado) || $nomeNormalizado === '') {
            return back()->withErrors(['nome' => 'O campo nome é obrigatório.'])->withInput();
        }

        $duplicataExiste = Modelo::whereRaw('LOWER(modelo) = ?', [strtolower($nomeNormalizado)])
            ->where('marca_id', $request->input('marca_id'))
            ->where('id', '!=', $modelo->id)
            ->exists();

        if ($duplicataExiste) {
            return redirect('gerenciar/modelo')->with('error', 'Este modelo já está registado para esta marca.');
        }

        $modelo->update([
            'modelo' => $nomeNormalizado,
            'marca_id' => $request->input('marca_id'),
        ]);

        return redirect()->route('admin.gerenciar.modelo.index')->with('success', 'Modelo atualizado com sucesso!');
    }

    public function destroy(Modelo $modelo)
    {
        $modelo->delete();
        return redirect()->route('admin.gerenciar.modelo.index')->with('success', 'Modelo apagado com sucesso!');
    }

    public function create()
    {
        $marcas = Marca::orderBy('nome')->pluck('nome', 'id');
        return view('admin.cadastro.modelo', ['marcas' => $marcas]);
    }

    public function store(Request $request){
        $request->validate([
            'modelo' => 'required|string|max:255',
            'marca_id' => 'required|exists:marcas,id',
        ]);

        if (Modelo::whereRaw('LOWER(modelo) = ?', [strtolower($request->input('modelo'))])
                ->where('marca_id', $request->input('marca_id'))
                ->exists()) {
            return redirect('gerenciar/modelo')->with('error', 'Este modelo já existe para esta marca!');
        }

        Modelo::create([
            'modelo' => $request['modelo'],
            'marca_id' => $request['marca_id'],
        ]);

        return redirect('gerenciar/modelo')->with('success', 'Modelo cadastrado com sucesso!');
    }
}
