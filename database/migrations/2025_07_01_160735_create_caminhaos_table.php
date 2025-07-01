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
        Schema::create('caminhaos', function (Blueprint $table) {
            $table->id();

            //  Dados sobre o caminhao
            $table->string('marca');
            $table->string('modelo');
            $table->year('anoFabricacao');
            $table->foreign('marca')->references('marca')->on('modelo');
            $table->foreign('modelo')->references('modelo')->on('modelo');

            //  Dados de documentacao
            $table->char('placa', length: 7);
            $table->char('renavam', length: 11);

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
