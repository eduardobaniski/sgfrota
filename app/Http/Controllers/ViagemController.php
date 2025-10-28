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

        // Último odômetro conhecido para este caminhão
        $lastFinal = Viagem::where('caminhao_id', $caminhao->id)
            ->whereNotNull('odometroFinal')
            ->max('odometroFinal');
        $lastStart = Viagem::where('caminhao_id', $caminhao->id)
            ->max('odometroInicio');
        $ultimoOdometro = max((int)($lastFinal ?? 0), (int)($lastStart ?? 0));

        return view('viagens.create', [
            'caminhao' => $caminhao,
            'estados' => $estados, // Envia a lista de estados para a view
            'motoristas' => $motoristas,
            'ultimoOdometro' => $ultimoOdometro,
        ]);
    }

     public function store(Request $request)
    {
        // 1. Valida os dados recebidos do formulário (regras básicas)
        $request->validate([
            'caminhao_id'   => 'required|exists:caminhoes,id',
            'motorista_id'  => 'required|exists:motoristas,id',
            'origem_id'     => 'required|exists:cities,id',
            'destino_id'    => 'required|exists:cities,id|different:origem_id',
            'data_inicio'   => 'required|date',
            'odometroInicio'=> 'required|integer|min:0',
        ]);

        $dadosValidados = [
            'caminhao_id' => (int) $request->input('caminhao_id'),
            'odometroInicio' => (int) $request->input('odometroInicio'),
            'dataInicio' => $request->input('data_inicio'),
            'cidadeOrigem' => (int) $request->input('origem_id'),
            'cidadeDestino' => (int) $request->input('destino_id'),
            'motorista_id' => (int) $request->input('motorista_id'),
        ];


        // 2. Busca o caminhão no banco de dados
        $caminhao = Caminhao::findOrFail($dadosValidados['caminhao_id']);

        // 3. VERIFICAÇÃO DE SEGURANÇA (redundante, mas importante):
        // Confirma novamente que o caminhão ainda está disponível antes de criar a viagem.
        if ($caminhao->status !== 'Disponível') {
            return redirect()->route('dashboard')
                         ->with('error', "Não foi possível iniciar a viagem. O caminhão {$caminhao->placa} já está em trânsito ou em manutenção.");
        }

        // 4. Regra de negócio: odômetro inicial não pode ser menor do que qualquer outro já relatado para este caminhão
        // Busca o maior odômetro anterior deste caminhão (considera finais e, na falta, inícios)
        $lastFinal = Viagem::where('caminhao_id', $dadosValidados['caminhao_id'])
            ->whereNotNull('odometroFinal')
            ->max('odometroFinal');
        $lastStart = Viagem::where('caminhao_id', $dadosValidados['caminhao_id'])
            ->max('odometroInicio');
        $ultimoOdometro = max((int)($lastFinal ?? 0), (int)($lastStart ?? 0));

        if ($dadosValidados['odometroInicio'] < $ultimoOdometro) {
            return back()->withErrors([
                'odometroInicio' => "O odômetro inicial ({$dadosValidados['odometroInicio']}) não pode ser inferior ao último registrado ({$ultimoOdometro}).",
            ])->withInput();
        }

        // 5. Cria a nova viagem no banco de dados
        // A data_fim fica nula por defeito, o que define a viagem como "ativa".
        Viagem::create($dadosValidados);

        // 6. Redireciona para o dashboard com uma mensagem de sucesso
        return redirect()->route('dashboard')->with('success', "Viagem para o caminhão {$caminhao->placa} iniciada com sucesso!");
    }

    public function edit(Viagem $viagem)
    {
        $viagem->load(['caminhao', 'motorista', 'origem.state', 'destino.state']);
        $estados = State::orderBy('name')->get();
        $motoristas = Motorista::orderBy('nome')->get(['id', 'nome']);

        // Sugerir odômetro final padrão: pelo menos o maior entre o odômetro de início desta viagem e o último conhecido de outras viagens do mesmo caminhão
        $lastFinal = Viagem::where('caminhao_id', $viagem->caminhao_id)
            ->where('id', '!=', $viagem->id)
            ->whereNotNull('odometroFinal')
            ->max('odometroFinal');
        $lastStart = Viagem::where('caminhao_id', $viagem->caminhao_id)
            ->where('id', '!=', $viagem->id)
            ->max('odometroInicio');
        $ultimoOdometroOutras = max((int)($lastFinal ?? 0), (int)($lastStart ?? 0));
        $sugestaoOdometroFinal = max((int)($viagem->odometroInicio ?? 0), $ultimoOdometroOutras);

        return view('viagens.edit', [
            'viagem' => $viagem,
            'estados' => $estados,
            'motoristas' => $motoristas,
            'sugestaoOdometroFinal' => $sugestaoOdometroFinal,
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
            // Regras básicas de validação
            $request->validate([
                'motorista_id' => 'nullable|exists:motoristas,id',
                'cidadeOrigem' => 'nullable|exists:cities,id',
                'cidadeDestino'=> 'nullable|exists:cities,id',
                'dataInicio'   => 'nullable|date',
                'odometroInicio'=> 'nullable|integer|min:0',
            ]);

            // Se informar odômetro inicial, garantir que não seja inferior ao último registrado (excluindo a própria viagem)
            if ($request->filled('odometroInicio')) {
                $lastFinal = Viagem::where('caminhao_id', $viagem->caminhao_id)
                    ->where('id', '!=', $viagem->id)
                    ->whereNotNull('odometroFinal')
                    ->max('odometroFinal');
                $lastStart = Viagem::where('caminhao_id', $viagem->caminhao_id)
                    ->where('id', '!=', $viagem->id)
                    ->max('odometroInicio');
                $ultimoOdometro = max((int)($lastFinal ?? 0), (int)($lastStart ?? 0));

                if ((int)$request->input('odometroInicio') < $ultimoOdometro) {
                    return back()->withErrors([
                        'odometroInicio' => "O odômetro inicial (".$request->input('odometroInicio').") não pode ser inferior ao último registrado ({$ultimoOdometro}).",
                    ])->withInput();
                }
            }

            $viagem->update(array_filter($dadosIniciais, fn($v) => $v !== null && $v !== ''));
            return redirect()->route('viagens.edit', $viagem)->with('success', 'Alterações da viagem salvas com sucesso!');
        }

        // Finalizar: inclui também os campos de término
        $dadosFinal = $dadosIniciais + [
            'dataFim' => $request->input('dataFim'),
            'odometroFinal' => $request->input('odometroFinal'),
        ];

        // Validações para finalização
        $request->validate([
            'dataFim' => 'required|date',
            'odometroFinal' => 'required|integer|min:0',
        ]);

        $lastFinal = Viagem::where('caminhao_id', $viagem->caminhao_id)
            ->where('id', '!=', $viagem->id)
            ->whereNotNull('odometroFinal')
            ->max('odometroFinal');
        $lastStart = Viagem::where('caminhao_id', $viagem->caminhao_id)
            ->where('id', '!=', $viagem->id)
            ->max('odometroInicio');
        $ultimoOdometro = max((int)($lastFinal ?? 0), (int)($lastStart ?? 0), (int)($viagem->odometroInicio ?? 0));

        $odometroFinalInformado = (int)$request->input('odometroFinal');
        if ($odometroFinalInformado < $ultimoOdometro) {
            return back()->withErrors([
                'odometroFinal' => "O odômetro final ({$odometroFinalInformado}) não pode ser inferior ao último registrado ({$ultimoOdometro}).",
            ])->withInput();
        }

        $viagem->update(array_filter($dadosFinal, fn($v) => $v !== null && $v !== ''));

        return redirect()->route('dashboard')->with('success', 'Viagem finalizada com sucesso!');
    }

    public function destroy(Viagem $viagem)
    {
        $viagem->delete();
        
        return redirect()->route('dashboard')->with('success', 'Viagem excluída com sucesso!');
    }
}
