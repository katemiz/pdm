<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('moms', function (Blueprint $table) {
            $table->id();
            $table->integer('updated_uid');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Company::class);
            $table->foreignIdFor(Project::class)->nullable();
            $table->integer('mom_no');
            $table->integer('revision')->default(1);
            $table->boolean('is_latest')->default(true);
            $table->date('mom_start_date');
            $table->date('mom_end_date')->nullable();
            $table->text('place')->nullable();
            $table->text('subject')->nullable();
            $table->text('meeting_type');
            $table->text('minutes')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('published_by')->nullable();
            $table->string('status')->default('WIP');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moms');
    }
};
