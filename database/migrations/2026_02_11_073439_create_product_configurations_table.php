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
        Schema::create('product_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('base_id')->constrained('items')->onDelete('cascade');
            $table->foreignId('configuration_id')->constrained('items')->onDelete('cascade');
            $table->timestamps();
            
            // Prevent duplicate combinations
            $table->unique(['base_id', 'configuration_id']);
            
            // Indexes for faster queries
            $table->index('base_id');
            $table->index('configuration_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_configurations');
    }
};
