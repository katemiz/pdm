<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


use App\Models\CNotice;
use App\Models\Malzeme;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->startingValue(102729);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(CNotice::class);
            $table->foreignIdFor(Malzeme::class);
            $table->string('unit')->default('mm');
            $table->integer('product_no');
            $table->integer('version')->default(0);
            $table->text('description')->nullable();
            $table->float('weight')->nullable();
            $table->foreignId('checker_id')->nullable();
            $table->foreignId('approver_id')->nullable();
            $table->string('reject_reason_check')->nullable();
            $table->string('reject_reason_app')->nullable();
            $table->date('check_reviewed_at')->nullable();
            $table->date('app_reviewed_at')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->default('wip');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
