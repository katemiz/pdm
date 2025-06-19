<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pproducts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ecn_id');
            $table->unsignedBigInteger('material_id');
            $table->enum('product_type', ['detail', 'standard', 'assy', 'make_from']);
            $table->string('product_number');
            $table->string('product_title');
            $table->string('version');
            $table->boolean('is_latest')->default(false);
            $table->enum('status', ['wip', 'frozen', 'released'])->default('wip');
            
            // Timestamps
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            
            // User tracking fields
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('checked_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            
            // Checker and approver timestamps
            $table->timestamp('checked_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            
            // Remarks fields
            $table->text('checker_remarks')->nullable();
            $table->text('checker_reject_remarks')->nullable();
            $table->text('approver_remarks')->nullable();
            $table->text('approver_reject_remarks')->nullable();
            
            // Foreign key constraints (optional - uncomment if you have these tables)
            // $table->foreign('ecn_id')->references('id')->on('ecns')->onDelete('cascade');
            // $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('checked_by')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            
            // Indexes for better performance
            $table->index('ecn_id');
            $table->index('material_id');
            $table->index('product_number');
            $table->index('status');
            $table->index(['ecn_id', 'material_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pproducts');
    }
};