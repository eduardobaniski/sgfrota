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
        Schema::create('viagens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caminhao_id')->constrained('caminhoes')->onDelete('cascade');

            $table->integer('odometroInicio')->nullable();
            $table->integer('odometroFinal')->nullable();
            $table->dateTime('dataInicio');
            $table->dateTime('dataFim')->nullable();

            $table->unsignedInteger('cidadeOrigem');
            $table->foreign('cidadeOrigem')->references('id')->on('cities');

            // Coluna para a cidade de destino
            $table->unsignedInteger('cidadeDestino');
            $table->foreign('cidadeDestino')->references('id')->on('cities');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viagens');
    }
};
