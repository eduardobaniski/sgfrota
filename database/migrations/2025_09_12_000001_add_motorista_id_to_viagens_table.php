<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('viagens', function (Blueprint $table) {
            if (!Schema::hasColumn('viagens', 'motorista_id')) {
                $table->foreignId('motorista_id')
                    ->nullable()
                    ->constrained('motoristas')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('viagens', function (Blueprint $table) {
            if (Schema::hasColumn('viagens', 'motorista_id')) {
                if (method_exists($table, 'dropConstrainedForeignId')) {
                    $table->dropConstrainedForeignId('motorista_id');
                } else {
                    $table->dropForeign(['motorista_id']);
                    $table->dropColumn('motorista_id');
                }
            }
        });
    }
};
