<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth; // Importe o Facade de Autenticação

class Sidebar extends Component
{
    /**
     * A lista de links de navegação da sidebar.
     *
     * @var array
     */
    public array $links = [];

    /**
     * Cria uma nova instância do componente.
     */
    public function __construct()
    {
        // Chama o método que constrói os links
        $this->links = $this->buildLinks();
    }

    /**
     * Constrói o array de links com base na função do utilizador.
     *
     * @return array
     */
    private function buildLinks(): array
    {
        $user = Auth::user();
        

        // Links que todos os utilizadores veem
        $baseLinks = [
            [
                'title' => 'Dashboard',
                'url' => route('dashboard'),
            ],
            [
                'title' => 'Motoristas',
                'url' => route('motorista.index'),
            ],
            [
                'title' => 'Caminhões',
                'url' => route('caminhoes.index'),
            ],
            [
                'title' => 'Relatórios',
                'url' => route('consumos'), //AJEITAR ROTA RELATORIOS USER PADRAO
            ],
        ];

        // Links exclusivos para administradores
        $adminLinks = [
            [
                'title' => 'Home',
                'url' => route('admin'),
            ],
            [
                'title' => 'Editar Marcas',
                'url' => route('admin.gerenciar.marca.index'),
            ],
            [
                'title' => 'Editar Modelos',
                'url' => route('admin.gerenciar.modelo.index'),
            ],
            [
                'title' => 'Editar Usuários',
                'url' => route('admin.gerenciar.user.index'),
            ],
        ];

        if ($user->isAdmin) {
            return $adminLinks;
        }

        return $baseLinks;
    }


    /**
     * Pega a view / conteúdo que representa o componente.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar');
    }
}
