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
        // Pega todos os dados do formulário
        $dados = $request->all();

        // Atualiza o caminhão com os dados recebidos
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
}
