<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('abastecimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caminhao_id')->constrained('caminhoes')->cascadeOnDelete();
            $table->foreignId('motorista_id')->nullable()->constrained('motoristas')->nullOnDelete();
            $table->foreignId('viagem_id')->nullable()->constrained('viagens')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->dateTime('data');
            $table->unsignedBigInteger('odometro')->nullable();
            $table->decimal('litros', 10, 3);
            $table->decimal('preco_por_litro', 10, 3)->nullable();
            $table->decimal('valor_total', 12, 2)->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->index(['caminhao_id', 'data']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abastecimentos');
    }
};
