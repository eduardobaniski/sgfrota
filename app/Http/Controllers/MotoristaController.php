<?php

namespace App\Http\Controllers;

use App\Models\Motorista;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MotoristaController extends Controller
{
    public function index(Request $request)
    {
        // Inicia a query
        $query = Motorista::query();

        // Se houver um termo de pesquisa, adiciona a condição 'where'
        if ($request->has('search') && $request->input('search') != '') {
            $searchTerm = '%' . $request->input('search') . '%';
            $query->where('nome', 'like', $searchTerm)
                  ->orWhere('cpf', 'like', $searchTerm)
                  ->orWhere('cnh', 'like', $searchTerm);
        }

        // Executa a query com ordenação e paginação
        $motoristas = $query->orderBy('nome')->paginate(15);
        // dd($motoristas);

        return view('motoristas.index', ['motoristas' => $motoristas]);
    }

    /**
     * Mostra o formulário para criar um novo motorista.
     */
    public function create()
    {
        return view('motoristas.create');
    }

    /**
     * Guarda o novo motorista no banco de dados.
     */
    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|size:11|unique:motoristas,cpf',
            'cnh' => 'required|string|size:11|unique:motoristas,cnh',
            'telefone' => 'nullable|string|max:20',
        ]);

        Motorista::create($dadosValidados);

        return redirect()->route('motorista.index')->with('success', 'Motorista registado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um motorista existente.
     */
    public function edit(Motorista $motorista)
    {
        return view('motoristas.edit', ['motorista' => $motorista]);
    }

    /**
     * Atualiza um motorista no banco de dados.
     */
    public function update(Request $request, Motorista $motorista)
    {
        $dadosValidados = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => ['required','string','size:11', Rule::unique('motoristas','cpf')->ignore($motorista->id)],
            'cnh' => ['required','string','size:11', Rule::unique('motoristas','cnh')->ignore($motorista->id)],
            'telefone' => 'nullable|string|max:20',
        ]);

        $motorista->update($dadosValidados);

        return redirect()->route('motorista.index')->with('success', 'Dados do motorista atualizados com sucesso!');
    }

    /**
     * Remove um motorista do banco de dados.
     */
    public function destroy(Motorista $motorista)
    {
        $motorista->delete();

        return redirect()->route('motorista.index')->with('success', 'Motorista apagado com sucesso!');
    }
}
