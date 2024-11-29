<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id()->startingValue(801);
            $table->foreignIdFor(User::class);
            $table->integer('updated_uid');

            $table->integer('revision')->default(1);

            $table->text('form');
            $table->text('family');
            $table->text('description');
            $table->text('specification');
            $table->text('remarks')->nullable();
            $table->string('status')->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
