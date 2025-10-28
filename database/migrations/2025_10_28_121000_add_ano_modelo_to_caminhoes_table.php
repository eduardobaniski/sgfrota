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
        Schema::table('caminhoes', function (Blueprint $table) {
            // Use year column similar to ano_fabricacao. Make it nullable for existing rows.
            $table->year('ano_modelo')->nullable()->after('ano_fabricacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('caminhoes', function (Blueprint $table) {
            $table->dropColumn('ano_modelo');
        });
    }
};
