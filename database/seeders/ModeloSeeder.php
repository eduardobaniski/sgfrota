<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Marca;
use App\Models\Modelo;

class ModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Limpa a tabela de modelos para evitar duplicatas
        Modelo::query()->delete();

        // Reabilita a verificação de chaves estrangeiras
        Schema::enableForeignKeyConstraints();

        // 2. Busca as marcas existentes no banco e cria um mapa 'nome' => 'id'
        $marcas = Marca::pluck('id', 'marca');

        // Verificação de segurança
        if ($marcas->isEmpty()) {
            $this->command->error('Nenhuma marca foi encontrada no banco de dados.');
            return;
        }

        // 3. Define a lista de modelos que você quer criar
        $dadosModelos = [
            // Volvo
            ['marca' => 'Volvo', 'modelo' => 'FH 540 Globetrotter'],
            ['marca' => 'Volvo', 'modelo' => 'FH 460'],
            ['marca' => 'Volvo', 'modelo' => 'FMX 500 8x4'],
            ['marca' => 'Volvo', 'modelo' => 'FM 380'],
            ['marca' => 'Volvo', 'modelo' => 'VM 270'],
            ['marca' => 'Volvo', 'modelo' => 'VM 330'],
            ['marca' => 'Volvo', 'modelo' => 'FH12 380 (Clássico)'],
            ['marca' => 'Volvo', 'modelo' => 'NL12 EDC (Clássico)'],

            // Scania
            ['marca' => 'Scania', 'modelo' => 'R 450 Plus'],
            ['marca' => 'Scania', 'modelo' => 'R 540'],
            ['marca' => 'Scania', 'modelo' => 'S 560 V8'],
            ['marca' => 'Scania', 'modelo' => 'G 410'],
            ['marca' => 'Scania', 'modelo' => 'P 360 Opticruise'],
            ['marca' => 'Scania', 'modelo' => '113H 360 (Clássico)'],
            ['marca' => 'Scania', 'modelo' => 'L 111 Jacaré (Lenda)'],

            // Mercedes-Benz
            ['marca' => 'Mercedes-Benz', 'modelo' => 'Actros 2651 S+'],
            ['marca' => 'Mercedes-Benz', 'modelo' => 'Actros 2548'],
            ['marca' => 'Mercedes-Benz', 'modelo' => 'Axor 3344'],
            ['marca' => 'Mercedes-Benz', 'modelo' => 'Atego 2430'],
            ['marca' => 'Mercedes-Benz', 'modelo' => 'Atego 1719'],
            ['marca' => 'Mercedes-Benz', 'modelo' => 'Accelo 1016'],
            ['marca' => 'Mercedes-Benz', 'modelo' => 'Accelo 815'],
            ['marca' => 'Mercedes-Benz', 'modelo' => 'L-1620 (Clássico)'],
            ['marca' => 'Mercedes-Benz', 'modelo' => '1113 (Lenda)'],

            // DAF
            ['marca' => 'DAF', 'modelo' => 'XF 530 FTT Super Space Cab'],
            ['marca' => 'DAF', 'modelo' => 'XF 480'],
            ['marca' => 'DAF', 'modelo' => 'CF 85.460'],
            ['marca' => 'DAF', 'modelo' => 'CF 300 Rigid'],

            // Volkswagen
            ['marca' => 'Volkswagen', 'modelo' => 'Meteor 28.460'],
            ['marca' => 'Volkswagen', 'modelo' => 'Meteor 29.520'],
            ['marca' => 'Volkswagen', 'modelo' => 'Constellation 24.280 V-Tronic'],
            ['marca' => 'Volkswagen', 'modelo' => 'Constellation 19.360'],
            ['marca' => 'Volkswagen', 'modelo' => 'Delivery 11.180'],
            ['marca' => 'Volkswagen', 'modelo' => 'Delivery 9.170'],
            ['marca' => 'Volkswagen', 'modelo' => 'Delivery Express'],
            ['marca' => 'Volkswagen', 'modelo' => 'Worker 15.190 (Clássico)'],
            ['marca' => 'Volkswagen', 'modelo' => 'Titan 18.310 (Clássico)'],

            // Iveco
            ['marca' => 'Iveco', 'modelo' => 'S-Way 540'],
            ['marca' => 'Iveco', 'modelo' => 'S-Way 480'],
            ['marca' => 'Iveco', 'modelo' => 'Hi-Way 440'],
            ['marca' => 'Iveco', 'modelo' => 'Tector 24-280'],
            ['marca' => 'Iveco', 'modelo' => 'Tector 9-190'],
            ['marca' => 'Iveco', 'modelo' => 'Daily 35-150'],
            ['marca' => 'Iveco', 'modelo' => 'Stralis 460'],

            // Ford (Modelos populares no mercado de usados, produção encerrada no Brasil)
            ['marca' => 'Ford', 'modelo' => 'Cargo 2429'],
            ['marca' => 'Ford', 'modelo' => 'Cargo 816'],
            ['marca' => 'Ford', 'modelo' => 'Cargo 1119'],
            ['marca' => 'Ford', 'modelo' => 'F-4000'],
            ['marca' => 'Ford', 'modelo' => 'F-250'],
            ['marca' => 'Ford', 'modelo' => 'F-600 (Clássico)'],

            // MAN
            ['marca' => 'MAN', 'modelo' => 'TGX 29.480'],
            ['marca' => 'MAN', 'modelo' => 'TGX 28.440'],
            ['marca' => 'MAN', 'modelo' => 'TGX 33.440'],

            // Agrale
            ['marca' => 'Agrale', 'modelo' => 'A8700'],
            ['marca' => 'Agrale', 'modelo' => 'A10000'],
            ['marca' => 'Agrale', 'modelo' => 'Linha S 10000 S'],
            ['marca' => 'Agrale', 'modelo' => 'Marruá AM200'],

            // Hyundai
            ['marca' => 'Hyundai', 'modelo' => 'HD 80 (antigo HD 78)'],
            ['marca' => 'Hyundai', 'modelo' => 'HR'],
            ['marca' => 'Hyundai', 'modelo' => 'Xcient'],
        ];

        // 4. Itera sobre a lista e cria cada modelo no banco de dados
        foreach ($dadosModelos as $dado) {
            $marcaId = $marcas->get($dado['marca']);

            if ($marcaId) {
                Modelo::create([
                    'modelo'   => $dado['modelo'],
                    'marca_id' => $marcaId, // Associa o modelo ao ID correto da marca
                ]);
            }
        }

    }
}
