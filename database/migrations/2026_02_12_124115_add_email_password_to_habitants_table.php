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
        Schema::table('habitants', function (Blueprint $table) {
            // Supprimer user_id car habitants auront leur propre auth
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            
            // Email existe déjà, on ajoute juste password
            $table->string('password')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('habitants', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        });
    }
};
