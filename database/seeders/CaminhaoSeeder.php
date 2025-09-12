<?php

namespace Database\Seeders;

use App\Models\Modelo;
use App\Models\Caminhao;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CaminhaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pega até 5 modelos existentes para associar aos caminhões.
        // Garanta que você já tenha modelos no seu banco de dados antes de executar.
        $modelos = Modelo::take(5)->pluck('id');

        // Se não houver modelos, exibe uma mensagem e para a execução.
        if ($modelos->isEmpty()) {
            $this->command->info('Nenhum modelo encontrado. Por favor, popule a tabela de modelos primeiro.');
            return;
        }

        $caminhoes = [
            [
                'modelo_id' => $modelos->random(),
                'ano_fabricacao' => '2022',
                'placa' => 'ABC1D23',
                'renavam' => '12345678901',
                
            ],
            [
                'modelo_id' => $modelos->random(),
                'ano_fabricacao' => '2021',
                'placa' => 'DEF4E56',
                'renavam' => '23456789012',
                 // Este caminhão começará em manutenção
            ],
            [
                'modelo_id' => $modelos->random(),
                'ano_fabricacao' => '2023',
                'placa' => 'GHI7F89',
                'renavam' => '34567890123',
                
            ],
        ];

        foreach ($caminhoes as $caminhaoData) {
            // Usa firstOrCreate para evitar criar duplicatas (baseado na placa)
            // se o seeder for executado novamente.
            Caminhao::firstOrCreate(['placa' => $caminhaoData['placa']], $caminhaoData);
        }
    }
}
