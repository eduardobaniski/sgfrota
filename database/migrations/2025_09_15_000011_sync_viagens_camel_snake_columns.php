<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Remove colunas geradas (se existirem) para permitir escrita
        DB::unprepared(<<<'SQL'
DO $$
BEGIN
    IF EXISTS (
        SELECT 1 FROM information_schema.columns
        WHERE table_schema = 'public' AND table_name = 'viagens' AND column_name = 'dataInicio'
    ) THEN
        ALTER TABLE "viagens" DROP COLUMN IF EXISTS "dataInicio";
    END IF;
    IF EXISTS (
        SELECT 1 FROM information_schema.columns
        WHERE table_schema = 'public' AND table_name = 'viagens' AND column_name = 'dataFim'
    ) THEN
        ALTER TABLE "viagens" DROP COLUMN IF EXISTS "dataFim";
    END IF;
END
$$;
SQL);

        // Cria colunas camelCase normais, se não existirem
        DB::unprepared('ALTER TABLE "viagens" ADD COLUMN IF NOT EXISTS "dataInicio" timestamp without time zone NULL;');
        DB::unprepared('ALTER TABLE "viagens" ADD COLUMN IF NOT EXISTS "dataFim" timestamp without time zone NULL;');

        // Backfill camelCase a partir de snake_case
        DB::unprepared('UPDATE "viagens" SET "dataInicio" = "data_inicio" WHERE "dataInicio" IS NULL AND "data_inicio" IS NOT NULL;');
        DB::unprepared('UPDATE "viagens" SET "dataFim" = "data_fim" WHERE "dataFim" IS NULL AND "data_fim" IS NOT NULL;');

        // Função de sincronização camelCase <-> snake_case
        DB::unprepared(<<<'SQL'
CREATE OR REPLACE FUNCTION viagens_sync_camel_snake() RETURNS trigger AS $BODY$
BEGIN
    -- dataInicio <-> data_inicio
    IF NEW."data_inicio" IS NULL AND NEW."dataInicio" IS NOT NULL THEN
        NEW."data_inicio" := NEW."dataInicio";
    ELSIF NEW."dataInicio" IS NULL AND NEW."data_inicio" IS NOT NULL THEN
        NEW."dataInicio" := NEW."data_inicio";
    END IF;

    -- dataFim <-> data_fim
    IF NEW."data_fim" IS NULL AND NEW."dataFim" IS NOT NULL THEN
        NEW."data_fim" := NEW."dataFim";
    ELSIF NEW."dataFim" IS NULL AND NEW."data_fim" IS NOT NULL THEN
        NEW."dataFim" := NEW."data_fim";
    END IF;

    RETURN NEW;
END
$BODY$ LANGUAGE plpgsql;
SQL);

        // Trigger BEFORE INSERT/UPDATE para sincronizar
        DB::unprepared('DROP TRIGGER IF EXISTS trg_viagens_sync_camel_snake ON "viagens";');
        DB::unprepared(<<<'SQL'
CREATE TRIGGER trg_viagens_sync_camel_snake
BEFORE INSERT OR UPDATE ON "viagens"
FOR EACH ROW
EXECUTE FUNCTION viagens_sync_camel_snake();
SQL);
    }

    public function down(): void
    {
        // Remove trigger e função
        DB::unprepared('DROP TRIGGER IF EXISTS trg_viagens_sync_camel_snake ON "viagens";');
        DB::unprepared('DROP FUNCTION IF EXISTS viagens_sync_camel_snake();');

        // Opcional: manter as colunas camelCase para compatibilidade; remova se quiser reverter totalmente:
        // DB::unprepared('ALTER TABLE "viagens" DROP COLUMN IF EXISTS "dataInicio";');
        // DB::unprepared('ALTER TABLE "viagens" DROP COLUMN IF EXISTS "dataFim";');
    }
};
