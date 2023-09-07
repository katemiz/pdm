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
        Schema::create('crequests', function (Blueprint $table) {
            $table->id()->startingValue(1071);
            $table->foreignIdFor(User::class);
            $table->string('topic');
            $table->boolean('is_for_ecn')->default(false);
            $table->foreignId('req_app_id')->nullable();
            $table->foreignId('eng_app_id')->nullable();
            $table->string('rej_reason_req')->nullable();
            $table->string('rej_reason_eng')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('wip');
            $table->date('req_reviewed_at')->nullable();
            $table->date('eng_reviewed_at')->nullable();
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crequests');
    }
};
