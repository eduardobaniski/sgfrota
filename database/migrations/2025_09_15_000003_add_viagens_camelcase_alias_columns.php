<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if ($this->hasColumnExact('viagens', 'data_fim') && !$this->hasColumnExact('viagens', 'dataFim')) {
            DB::statement('ALTER TABLE "viagens" ADD COLUMN "dataFim" timestamp without time zone GENERATED ALWAYS AS ("data_fim") STORED;');
        }
        if ($this->hasColumnExact('viagens', 'data_inicio') && !$this->hasColumnExact('viagens', 'dataInicio')) {
            DB::statement('ALTER TABLE "viagens" ADD COLUMN "dataInicio" timestamp without time zone GENERATED ALWAYS AS ("data_inicio") STORED;');
        }
    }

    public function down(): void
    {
        if ($this->hasColumnExact('viagens', 'dataFim')) {
            DB::statement('ALTER TABLE "viagens" DROP COLUMN "dataFim";');
        }
        if ($this->hasColumnExact('viagens', 'dataInicio')) {
            DB::statement('ALTER TABLE "viagens" DROP COLUMN "dataInicio";');
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
