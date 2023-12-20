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
        Schema::create('urun_yaptirga', function (Blueprint $table) {

            $table->unsignedBigInteger('urun_id');
            $table->unsignedBigInteger('yaptirga_id');
            $table->timestamps();

            $table->foreign('urun_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('yaptirga_id')->references('id')->on('pnotes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urun_yaptirga');
    }
};
