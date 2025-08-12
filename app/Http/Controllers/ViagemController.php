<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Viagem;
use App\Models\Caminhao;
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
        // Busca todos os estados únicos, ordenados alfabeticamente
        $estados = State::orderBy('name')->get();

        return view('viagens.create', [
            'caminhao' => $caminhao,
            'estados' => $estados // Envia a lista de estados para a view
        ]);
    }

     public function store(Request $request)
    {
        // 1. Valida os dados recebidos do formulário
        $dadosValidados = [
            'caminhao_id' => $request->input('caminhao_id'),
            'odometroInicio' => $request->input('odometroInicio'),
            'dataInicio' => $request->input('data_inicio'),
        ];


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
