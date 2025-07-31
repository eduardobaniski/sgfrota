<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public array $links = [];
    public function __construct()
    {
        //
        $this->links = [
            [
                'title' => 'Dashboard',
                'url' => '/dashboard',
                // 'url' => route('dashboard'),
            ],
            [
                'title' => 'Usuários',
                'url' => '#',
            ],
            [
                'title' => 'Relatórios',
                'url' => '#',
            ],
        ];
    }
    

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
