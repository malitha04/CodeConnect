<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Added this import for DB facade

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // First add the 'user_id' column as nullable
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        });

        // Populate user_id with existing client_id values
        DB::statement('UPDATE projects SET user_id = client_id WHERE client_id IS NOT NULL');

        // Now make the column not nullable and add foreign key
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            
            // Creates a foreign key constraint. This ensures every project is linked to a valid user.
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Drop the foreign key first to avoid errors
            $table->dropForeign(['user_id']);
            
            // Then drop the 'user_id' column
            $table->dropColumn('user_id');
        });
    }
};

