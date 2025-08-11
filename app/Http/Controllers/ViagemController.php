<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViagemController extends Controller
{
    public function create(Caminhao $caminhao)
    {
        // VERIFICAÇÃO DE SEGURANÇA:
        // Garante que só é possível iniciar uma viagem para um caminhão que esteja disponível.
        if ($caminhao->status !== 'Disponível') {
            return redirect()->route('dashboard') // Redireciona para o dashboard principal
                         ->with('error', "Ação não permitida! O caminhão {$caminhao->placa} não está disponível.");
        }

        // Retorna a view do formulário, passando os dados do caminhão
        return view('viagens.create', ['caminhao' => $caminhao]);
    }

     public function store(Request $request)
    {
        // 1. Valida os dados recebidos do formulário
        $dadosValidados = $request->validate([
            'caminhao_id' => 'required|exists:caminhoes,id',
            'origem' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'data_inicio' => 'required|date',
        ]);

        // 2. Busca o caminhão no banco de dados
        $caminhao = Caminhao::findOrFail($dadosValidados['caminhao_id']);

        // 3. VERIFICAÇÃO DE SEGURANÇA (redundante, mas importante):
        // Confirma novamente que o caminhão ainda está disponível antes de criar a viagem.
        if ($caminhao->status !== 'Disponível') {
            return redirect()->route('dashboard')
                         ->with('error', "Não foi possível iniciar a viagem. O caminhão {$caminhao->placa} já está em trânsito ou em manutenção.");
        }

        // 4. Cria a nova viagem no banco de dados
        // A data_fim fica nula por defeito, o que define a viagem como "ativa".
        Viagem::create($dadosValidados);

        // 5. Redireciona para o dashboard com uma mensagem de sucesso
        return redirect()->route('dashboard')->with('success', "Viagem para o caminhão {$caminhao->placa} iniciada com sucesso!");
    }
}
