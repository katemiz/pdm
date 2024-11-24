<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\Company;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Company::class);
            $table->integer('updated_uid');
            $table->integer('document_no');
            $table->integer('revision')->default(1);
            $table->boolean('is_html')->default(false);
            $table->boolean('is_latest')->default(true);
            $table->string('doc_type');
            $table->string('language')->default('TR');
            $table->text('title');
            $table->text('remarks')->nullable();
            $table->json('toc');
            $table->foreignId('checker_id')->nullable();
            $table->foreignId('approver_id')->nullable();
            $table->string('reject_reason_check')->nullable();
            $table->string('reject_reason_app')->nullable();
            $table->dateTime('check_reviewed_at')->nullable();
            $table->dateTime('app_reviewed_at')->nullable();
            $table->string('status')->default('Verbatim');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
