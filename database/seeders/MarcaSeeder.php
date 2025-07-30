<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $marcas = [
            ['nome' => 'Volvo'],
            ['nome' => 'Scania'],
            ['nome' => 'Mercedes-Benz'],
            ['nome' => 'DAF'],
            ['nome' => 'Volkswagen'], 
            ['nome' => 'Iveco'],
            ['nome' => 'Ford'], 
            ['nome' => 'MAN'], 
            ['nome' => 'Agrale'], 
            ['nome' => 'Hyundai'], 
        ];

        foreach ($marcas as &$marca) {
            Marca::create([
                'marca' => $marca['nome']
            ]);
        }

        
    }
}

