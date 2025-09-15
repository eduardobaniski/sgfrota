<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Renomeia apenas se a coluna em camelCase existir e a em snake_case não existir
        if ($this->hasColumnExact('viagens', 'dataFim') && !$this->hasColumnExact('viagens', 'data_fim')) {
            DB::statement('ALTER TABLE "viagens" RENAME COLUMN "dataFim" TO "data_fim";');
        }

        // Opcional: faça o mesmo para dataInicio -> data_inicio, se aplicável ao seu domínio
        if ($this->hasColumnExact('viagens', 'dataInicio') && !$this->hasColumnExact('viagens', 'data_inicio')) {
            DB::statement('ALTER TABLE "viagens" RENAME COLUMN "dataInicio" TO "data_inicio";');
        }
    }

    public function down(): void
    {
        if ($this->hasColumnExact('viagens', 'data_fim') && !$this->hasColumnExact('viagens', 'dataFim')) {
            DB::statement('ALTER TABLE "viagens" RENAME COLUMN "data_fim" TO "dataFim";');
        }

        if ($this->hasColumnExact('viagens', 'data_inicio') && !$this->hasColumnExact('viagens', 'dataInicio')) {
            DB::statement('ALTER TABLE "viagens" RENAME COLUMN "data_inicio" TO "dataInicio";');
        }
    }

    private function hasColumnExact(string $table, string $column): bool
    {
        $result = DB::select(
            'select 1 from information_schema.columns where table_schema = ? and table_name = ? and column_name = ? limit 1',
            ['public', $table, $column]
        );

        return !empty($result);
    }
};
