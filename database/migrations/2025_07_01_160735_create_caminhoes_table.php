<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('caminhoes', function (Blueprint $table) {
            $table->id();

            //  Dados sobre o caminhao
            // Relação com o modelo
            $table->foreignId('modelo_id')->constrained('modelos')->onDelete('cascade');

            // Dados específicos do caminhão
            $table->year('ano_fabricacao');
            $table->char('placa', 7)->unique();
            $table->string('renavam', 11)->unique();
            $table->string('status')->default('Disponível'); // Ex: Disponível, Em Trânsito, Em Manutenção


        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caminhaos');
    }
};
