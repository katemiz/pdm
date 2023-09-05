<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\Cr;


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
            $table->foreignIdFor(Cr::class);

            $table->text('pre_description')->nullable();

            // $table->string('topic');
            // $table->boolean('is_for_ecn')->default(false);
            // $table->foreignId('req_app_id')->nullable();
            // $table->foreignId('eng_app_id')->nullable();
            // $table->string('rej_reason_req')->nullable();
            // $table->string('rej_reason_eng')->nullable();
            // $table->text('description')->nullable();
            // $table->string('status')->default('wip');
            // $table->date('req_reviewed_at');
            // $table->date('eng_reviewed_at');
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
