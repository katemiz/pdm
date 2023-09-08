<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\CNotice;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ecns', function (Blueprint $table) {
            $table->id()->startingValue(1071);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(CNotice::class);
            $table->text('pre_description')->nullable();
            $table->string('status')->default('wip');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecns');
    }
};
