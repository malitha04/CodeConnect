<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if client_id column exists and user_id is properly populated
        if (Schema::hasColumn('projects', 'client_id') && Schema::hasColumn('projects', 'user_id')) {
            // Ensure user_id has values from client_id
            DB::statement('UPDATE projects SET user_id = client_id WHERE user_id IS NULL AND client_id IS NOT NULL');
            
            // Drop the client_id column since we now have user_id
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('client_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate client_id column if needed
        if (!Schema::hasColumn('projects', 'client_id')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->unsignedBigInteger('client_id')->nullable()->after('user_id');
            });
            
            // Populate client_id with user_id values
            DB::statement('UPDATE projects SET client_id = user_id WHERE user_id IS NOT NULL');
        }
    }
};
