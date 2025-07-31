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
        schema::create('proposals', function (Blueprint $table) {        
            $table->id();        
            $table->foreignId('project_id')->constrained()->onDelete('cascade');        
            $table->foreignId('developer_id')->constrained('users')->onDelete('cascade');        
            $table->text('cover_letter');        $table->decimal('bid_amount', 10, 2);        
            $table->string('status')->default('pending'); // e.g., pending, accepted, rejected        
            $table->timestamps();    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
