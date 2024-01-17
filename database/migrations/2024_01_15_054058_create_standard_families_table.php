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
        Schema::create('standard_families', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->integer('updated_uid');
            $table->string('standard_number')->unique();
            $table->text('description')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standard_families');
    }
};
