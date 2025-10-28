<?php

namespace App\Http\Controllers;

use App\Models\Motorista;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class MotoristaController extends Controller
{
    public function index(Request $request)
    {
        // Inicia a query
        $status = $request->input('status', 'ativos'); // ativos | inativos | todos
        $cnhStatus = $request->input('cnh_status', 'todas'); // todas | vencidas | vence30 | validas
        $query = Motorista::query();

        if ($status === 'inativos') {
            $query->onlyTrashed();
        } elseif ($status === 'todos') {
            $query->withTrashed();
        }

        // Filtro por status da CNH
        $hoje = Carbon::today();
        if ($cnhStatus === 'vencidas') {
            $query->whereDate('cnh_validade', '<', $hoje);
        } elseif ($cnhStatus === 'vence30') {
            $query->whereDate('cnh_validade', '>=', $hoje)
                  ->whereDate('cnh_validade', '<=', $hoje->copy()->addDays(30));
        } elseif ($cnhStatus === 'validas') {
            $query->whereDate('cnh_validade', '>=', $hoje->copy()->addDays(31));
        }

        // Se houver um termo de pesquisa, adiciona a condição 'where' (agrupada)
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->input('search') . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('nome', 'like', $searchTerm)
                  ->orWhere('cpf', 'like', $searchTerm)
                  ->orWhere('cnh', 'like', $searchTerm);
            });
        }

    // Executa a query com ordenação e paginação, mantendo filtros
    $motoristas = $query->orderBy('nome')->paginate(15)->withQueryString();
        // dd($motoristas);

        return view('motoristas.index', [
            'motoristas' => $motoristas,
            'status' => $status,
            'cnh_status' => $cnhStatus,
        ]);
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
            'cpf' => [
                'required','string','size:11',
                Rule::unique('motoristas','cpf')->where(function($q){
                    return $q->whereNull('deleted_at');
                }),
            ],
            'cnh' => [
                'required','string','size:11',
                Rule::unique('motoristas','cnh')->where(function($q){
                    return $q->whereNull('deleted_at');
                }),
            ],
            'cnh_validade' => 'required|date',
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
            'cpf' => [
                'required','string','size:11',
                Rule::unique('motoristas','cpf')
                    ->ignore($motorista->id)
                    ->where(function($q){ return $q->whereNull('deleted_at'); }),
            ],
            'cnh' => [
                'required','string','size:11',
                Rule::unique('motoristas','cnh')
                    ->ignore($motorista->id)
                    ->where(function($q){ return $q->whereNull('deleted_at'); }),
            ],
            'cnh_validade' => 'required|date',
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

    /**
     * Restaura um motorista soft-deletado.
     */
    public function restore(string $id)
    {
        $motorista = Motorista::withTrashed()->findOrFail($id);
        $motorista->restore();
        return redirect()->route('motorista.index')->with('success', 'Motorista restaurado com sucesso!');
    }
}
