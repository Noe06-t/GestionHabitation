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
        Schema::table('certificats', function (Blueprint $table) {
            $table->enum('statut', ['en_attente', 'paye'])->default('en_attente')->after('habitant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificats', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
};
