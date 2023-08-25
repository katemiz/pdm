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
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('topic');
            $table->boolean('is_for_ecn')->default(false);
            //$table->string('req_approver')->nullable();
            $table->foreignId('req_app_id')->nullable();
            //$table->string('eng_approver')->nullable();
            $table->foreignId('eng_app_id')->nullable();
            $table->string('rej_reason_req')->nullable();
            $table->string('rej_reason_eng')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('wip');
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
