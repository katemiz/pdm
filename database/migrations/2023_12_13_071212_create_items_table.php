<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\User;
use App\Models\CNotice;
use App\Models\Malzeme;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('updated_uid');
            $table->string('part_type');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(CNotice::class)->nullable();
            $table->foreignIdFor(Malzeme::class)->nullable();
            $table->string('unit')->default('mm');
            $table->integer('part_number');
            $table->text('description')->nullable();
            $table->text('part_number_mt')->nullable();
            $table->text('part_number_wb')->nullable();

            $table->integer('has_mirror')->nullable();
            $table->integer('is_mirror_of')->nullable();

            $table->integer('standard_family_id')->nullable();
            $table->text('standard_number')->nullable();
            $table->text('std_params')->nullable();
            $table->json('bom')->nullable();
            $table->integer('makefrom_part_id')->nullable();
            $table->integer('version')->default(0);
            $table->boolean('is_latest')->default(true);
            $table->text('vendor')->nullable();
            $table->text('vendor_part_no')->nullable();
            $table->text('url')->nullable();
            $table->float('weight',8,3)->nullable();
            $table->text('material_text')->nullable();
            $table->text('finish_text')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->default('WIP');
            $table->foreignId('checker_id')->nullable();
            $table->foreignId('approver_id')->nullable();
            $table->string('reject_reason_check')->nullable();
            $table->string('reject_reason_app')->nullable();
            $table->date('check_reviewed_at')->nullable();
            $table->date('app_reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
