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
        Schema::create('endproducts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->integer('updated_uid');
            $table->integer('part_number');
            $table->text('part_number_mt')->nullable();
            $table->text('part_number_wb')->nullable();
            $table->text('product_type')->nullable();
            $table->text('nomenclature')->nullable();
            $table->text('description')->nullable();
            $table->integer('version')->default('0');
            $table->boolean('is_latest')->default(true);
            $table->text('mast_family_mt')->nullable();
            $table->text('mast_family_wb')->nullable();
            $table->text('drive_type')->nullable();
            $table->integer('extended_height_mm')->nullable();
            $table->integer('extended_height_in')->nullable();
            $table->integer('nested_height_mm')->nullable();
            $table->integer('nested_height_in')->nullable();
            $table->float('product_weight_kg')->nullable();
            $table->float('max_payload_kg')->nullable();
            $table->integer('max_payload_lb')->nullable();
            $table->float('design_sail_area')->nullable();
            $table->float('design_drag_coefficient')->nullable();
            $table->integer('max_operational_wind_speed')->nullable();
            $table->integer('max_survival_wind_speed')->nullable();
            $table->integer('number_of_sections')->nullable();
            $table->text('has_locking')->nullable();
            $table->float('max_pressure_in_bar')->nullable();
            $table->integer('manual_doc_number')->nullable();
            $table->boolean('payload_interface')->default(true);
            $table->boolean('roof_interface')->default(false);
            $table->boolean('side_interface')->default(true);
            $table->boolean('bottom_interface')->default(true);
            $table->boolean('guying_interface')->default(true);
            $table->integer('number_of_guying_interfaces')->nullable();
            $table->boolean('hoisting_interface')->default(true);
            $table->boolean('lubrication_interface')->default(true);
            $table->boolean('manual_override_interface')->default(true);
            $table->boolean('wire_management')->default(false);
            $table->boolean('drainage')->default(false);
            $table->boolean('wire_basket')->default(false);
            $table->boolean('vdc12_interface')->default(false);
            $table->boolean('vdc24_interface')->default(false);
            $table->boolean('vdc28_interface')->default(false);
            $table->boolean('ac110_interface')->default(false);
            $table->boolean('ac220_interface')->default(false);
            $table->text('material')->nullable();
            $table->text('finish')->nullable();
            $table->foreignId('checker_id')->nullable();
            $table->foreignId('approver_id')->nullable();
            $table->string('reject_reason_check')->nullable();
            $table->string('reject_reason_app')->nullable();
            $table->date('check_reviewed_at')->nullable();
            $table->date('app_reviewed_at')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->default('WIP');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endproducts');
    }
};
