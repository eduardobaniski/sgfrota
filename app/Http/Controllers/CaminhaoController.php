<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Caminhao;
use Illuminate\Http\Request;

class CaminhaoController extends Controller
{
    public static function all(){
        // Exemplo no seu controlador do dashboard
        $caminhoes = Caminhao::with([
            'modelo.marca', 
            'viagens' => function ($query) {
                // Carrega apenas as viagens onde a data de fim é nula (ativas)
                $query->whereNull('dataFim')->with(['origem.state', 'destino.state']);
            }
        ])->get();
        return $caminhoes;
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
        // Validação simples
        $dados = $request->validate([
            'modelo_id' => 'required|exists:modelos,id',
            'ano_fabricacao' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'ano_modelo' => 'required|integer|min:1900|max:' . (date('Y') + 2),
            'placa' => 'required|string|size:7',
            'renavam' => 'required|string|size:11',
        ]);

        // Cria o caminhão no banco de dados
        Caminhao::create([
            'modelo_id' => $dados['modelo_id'],
            'ano_fabricacao' => $dados['ano_fabricacao'],
            'ano_modelo' => $dados['ano_modelo'],
            'placa' => strtoupper($dados['placa']),
            'renavam' => $dados['renavam'],
        ]);

        // Redireciona para uma futura página de listagem com uma mensagem de sucesso
        // Por agora, vamos redirecionar de volta para o formulário de criação
        return redirect()->route('dashboard')->with('success', 'Caminhão registado com sucesso!');
    }

    public function edit(Caminhao $caminhao)
    {
        $marcas = Marca::orderBy('nome')->get();

        // Reutiliza a mesma view do registo, mas passa os dados do caminhão
        return view('caminhoes.edit', [
            'caminhao' => $caminhao,
            'marcas' => $marcas
        ]);
    }

    public function update(Request $request, Caminhao $caminhao)
    {
        $dados = $request->validate([
            'modelo_id' => 'required|exists:modelos,id',
            'ano_fabricacao' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'ano_modelo' => 'required|integer|min:1900|max:' . (date('Y') + 2),
            'placa' => 'required|string|size:7',
            'renavam' => 'required|string|size:11',
        ]);

        $dados['placa'] = strtoupper($dados['placa']);
        $caminhao->update($dados);

        // Idealmente, redirecionaria para a página de listagem de caminhões
        return redirect()->route('dashboard')->with('success', 'Caminhão atualizado com sucesso!');
    }
    
    public function destroy(Caminhao $caminhao)
    {
        // Opcional: Adicionar uma verificação de autorização aqui
        // para garantir que o utilizador autenticado pode apagar este caminhão.

        $caminhao->delete();

        // Redireciona para uma página de listagem (quando existir) com uma mensagem de sucesso
        return redirect()->route('dashboard')->with('success', 'Caminhão apagado com sucesso!');
    }

    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 15);

        $query = Caminhao::with(['modelo.marca'])
            ->orderBy('placa');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('placa', 'like', "%{$search}%")
                  ->orWhereHas('modelo', function($q2) use ($search) {
                      $q2->where('modelo', 'like', "%{$search}%")
                         ->orWhereHas('marca', function($q3) use ($search) {
                             $q3->where('marca', 'like', "%{$search}%");
                         });
                  });
            });
        }

        $caminhoes = $query->paginate($perPage)->withQueryString();

        return view('caminhoes.index', compact('caminhoes'));
    }
}
