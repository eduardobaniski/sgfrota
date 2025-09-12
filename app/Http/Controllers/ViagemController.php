<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Viagem;
use App\Models\Caminhao;
use App\Models\Motorista;
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
        $motoristas = Motorista::orderBy('nome')->get(['id', 'nome']);

        return view('viagens.create', [
            'caminhao' => $caminhao,
            'estados' => $estados, // Envia a lista de estados para a view
            'motoristas' => $motoristas,
        ]);
    }

     public function store(Request $request)
    {
        // 1. Valida os dados recebidos do formulário
        $dadosValidados = [
            'caminhao_id' => $request->input('caminhao_id'),
            'odometroInicio' => $request->input('odometroInicio'),
            'dataInicio' => $request->input('data_inicio'),
            'cidadeOrigem' => $request->input('origem_id'),
            'cidadeDestino' => $request->input('destino_id'),
            'motorista_id' => $request->input('motorista_id'),
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

    public function edit(Viagem $viagem)
    {
        $viagem->load(['caminhao', 'motorista', 'origem.state', 'destino.state']);
        $estados = State::orderBy('name')->get();
        $motoristas = Motorista::orderBy('nome')->get(['id', 'nome']);

        return view('viagens.edit', [
            'viagem' => $viagem,
            'estados' => $estados,
            'motoristas' => $motoristas,
        ]);
    }

    public function update(Request $request, Viagem $viagem)
    {
        $action = $request->input('action', 'finalize');

        // Campos iniciais que podem ser salvos sem finalizar
        $dadosIniciais = [
            'motorista_id' => $request->input('motorista_id'),
            'odometroInicio' => $request->input('odometroInicio'),
            'dataInicio' => $request->input('dataInicio'),
            'cidadeOrigem' => $request->input('cidadeOrigem'),
            'cidadeDestino' => $request->input('cidadeDestino'),
        ];

        if ($action === 'save') {
            // Salva somente alterações sem finalizar
            $viagem->update(array_filter($dadosIniciais, fn($v) => $v !== null && $v !== ''));
            return redirect()->route('viagens.edit', $viagem)->with('success', 'Alterações da viagem salvas com sucesso!');
        }

        // Finalizar: inclui também os campos de término
        $dadosFinal = $dadosIniciais + [
            'dataFim' => $request->input('dataFim'),
            'odometroFinal' => $request->input('odometroFinal'),
        ];

        $viagem->update(array_filter($dadosFinal, fn($v) => $v !== null && $v !== ''));

        return redirect()->route('dashboard')->with('success', 'Viagem finalizada com sucesso!');
    }

    public function destroy(Viagem $viagem)
    {
        $viagem->delete();
        
        return redirect()->route('dashboard')->with('success', 'Viagem excluída com sucesso!');
    }
}
