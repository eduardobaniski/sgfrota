@extends('layout')
@section('title', 'Dashboard da Frota')
@props(['caminhoes'])
@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <!-- Cria um grid para organizar os cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

        <!-- Para cada caminhão na lista... -->
        @foreach ($caminhoes as $caminhao)
            <!-- ...use o molde 'truck-card' para criar um card -->
            <x-card-caminhao :caminhao="$caminhao" />
        @endforeach

    </div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
    /**
     * Objeto de configuração para mapear o status do caminhão às suas respectivas classes de CSS (Tailwind).
     * Isso centraliza a lógica de estilização e facilita a manutenção.
     */
    const statusClasses = {
        'Em Trânsito': {
            border: 'border-blue-500',
            bg: 'bg-blue-500'
        },
        'Disponível': {
            border: 'border-green-500',
            bg: 'bg-green-500'
        },
        'Em Manutenção': {
            border: 'border-yellow-500',
            bg: 'bg-yellow-500'
        },
        'default': {
            border: 'border-gray-400',
            bg: 'bg-gray-400'
        }
    };

    /**
     * Função auxiliar para atualizar a aparência do card principal (bordas e badge de status).
     * @param {string} truckId - O ID do caminhão.
     * @param {string} novoStatus - O novo status vindo da API.
     */
    function atualizarCardStatus(truckId, novoStatus) {
        const card = document.getElementById(`card-caminhao-${truckId}`);
        const badge = document.getElementById(`badge-status-${truckId}`);
        
        if (!card || !badge) {
            console.error(`Elementos do card para o caminhão ${truckId} não encontrados.`);
            return;
        }

        // Atualiza o texto do badge com o novo status.
        badge.textContent = novoStatus;
        
        // Remove todas as classes de status antigas para evitar conflitos.
        Object.values(statusClasses).forEach(classes => {
            card.classList.remove(classes.border);
            badge.classList.remove(classes.bg);
        });

        // Adiciona as novas classes com base no status recebido.
        const classes = statusClasses[novoStatus] || statusClasses['default'];
        card.classList.add(classes.border);
        badge.classList.add(classes.bg);
    }

    // Seleciona todos os botões "Ver Viagem" da página de uma só vez.
    const verViagemButtons = document.querySelectorAll('.ver-viagem-btn');

    // Itera sobre cada botão para adicionar o listener de clique.
    // Este código agora roda apenas UMA VEZ para a página inteira.
    verViagemButtons.forEach(button => {
        button.addEventListener('click', function() {
            const truckId = this.dataset.truckId;
            const detailsContainer = document.getElementById(`viagem-details-${truckId}`);

            if (!detailsContainer) {
                console.error(`Container de detalhes para o caminhão ${truckId} não encontrado.`);
                return;
            }

            // Verifica se o painel de detalhes já está visível para alternar (efeito "accordion").
            const isVisible = !detailsContainer.classList.contains('hidden');

            if (isVisible) {
                // Se estiver visível, simplesmente esconde e limpa o conteúdo.
                detailsContainer.classList.add('hidden');
                detailsContainer.innerHTML = '';
            } else {
                // Se estiver oculto, exibe a mensagem de carregamento e busca os dados.
                detailsContainer.innerHTML = '<p class="text-sm text-gray-500">A carregar detalhes da viagem...</p>';
                detailsContainer.classList.remove('hidden');

                // Executa a chamada à API para buscar os dados da viagem ativa.
                fetch(`/api/caminhoes/${truckId}/viagem-ativa`)
                    .then(response => {
                        // Trata respostas que não sejam bem-sucedidas (ex: 404, 500).
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.message || 'Erro ao buscar dados da viagem.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // **SUCESSO: A API retornou os dados da viagem.**

                        // 1. Atualiza o status do card principal (badge e borda).
                        // Lembre-se que sua API precisa retornar o campo 'statusCaminhao'.
                        if (data.statusCaminhao) {
                            atualizarCardStatus(truckId, data.statusCaminhao);
                        }

                        // 2. Formata a data para exibição.
                        const dataInicio = new Date(data.dataInicio);
                        const dataFormatada = dataInicio.toLocaleDateString('pt-BR', {
                            day: '2-digit', month: '2-digit', year: 'numeric', timeZone: 'UTC'
                        });

                        // 3. Monta o HTML completo dos detalhes da viagem e o injeta no container.
                        detailsContainer.innerHTML = `
                            <h4 class="font-bold text-md mb-3 text-gray-700">Viagem em Andamento</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500">Origem</p>
                                    <p class="font-semibold">${data.origem}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Destino</p>
                                    <p class="font-semibold">${data.destino}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Início</p>
                                    <p class="font-semibold">${dataFormatada}</p>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-200 flex justify-end">
                                <a href="/viagens/${data.id}/editar" class="text-sm bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
                                    Gerenciar Viagem
                                </a>
                            </div>
                        `;
                    })
                    .catch(error => {
                        // **ERRO: A API retornou um erro (ex: 404) ou a requisição falhou.**
                        // Exibe a mensagem de erro de forma clara no container.
                        console.error('Erro ao buscar viagem:', error);
                        detailsContainer.innerHTML = `<p class="text-sm text-red-500">${error.message}</p>`;
                    });
            }
        });
    });
});
</script>
    </body>
</html>