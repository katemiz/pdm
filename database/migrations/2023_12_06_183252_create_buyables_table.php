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
        Schema::create('buyables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->integer('updated_uid');
            $table->integer('part_number');
            $table->text('part_number_mt')->nullable();
            $table->text('part_number_wb')->nullable();
            $table->integer('version')->default('0');
            $table->boolean('is_latest')->default(true);
            $table->text('vendor')->nullable();
            $table->text('vendor_part_no')->nullable();
            $table->text('description')->nullable();
            $table->text('url')->nullable();
            $table->float('weight')->nullable();
            $table->text('material')->nullable();
            $table->text('finish')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('WIP');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyables');
    }
};
