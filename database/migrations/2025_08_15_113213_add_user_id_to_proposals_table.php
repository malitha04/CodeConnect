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
        Schema::table('proposals', function (Blueprint $table) {
            // Add the user_id column as an unsigned big integer.
            $table->unsignedBigInteger('user_id')->after('id');

            // Add a foreign key constraint to the users table.
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            // Drop the foreign key and the column if we roll back.
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
