<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mat_materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 20)->unique();
            $table->text('description')->nullable();
            
            // Foreign keys
            $table->foreignId('mat_family_id')->constrained('mat_families')->onDelete('cascade');
            $table->foreignId('mat_form_id')->constrained('mat_forms')->onDelete('cascade');
            
            // Mechanical Properties
            $table->decimal('tensile_strength', 10, 2)->nullable()->comment('MPa');
            $table->decimal('yield_strength', 10, 2)->nullable()->comment('MPa');
            $table->decimal('elongation', 5, 2)->nullable()->comment('%');
            $table->decimal('hardness', 8, 2)->nullable()->comment('HB/HRC');
            $table->decimal('elastic_modulus', 12, 2)->nullable()->comment('GPa');
            $table->decimal('density', 8, 4)->nullable()->comment('g/cm³');
            $table->decimal('poisson_ratio', 4, 3)->nullable();
            
            // Chemical Properties
            $table->decimal('carbon_content', 5, 3)->nullable()->comment('%');
            $table->decimal('silicon_content', 5, 3)->nullable()->comment('%');
            $table->decimal('manganese_content', 5, 3)->nullable()->comment('%');
            $table->decimal('phosphorus_content', 5, 3)->nullable()->comment('%');
            $table->decimal('sulfur_content', 5, 3)->nullable()->comment('%');
            $table->decimal('chromium_content', 5, 3)->nullable()->comment('%');
            $table->decimal('nickel_content', 5, 3)->nullable()->comment('%');
            $table->decimal('molybdenum_content', 5, 3)->nullable()->comment('%');
            $table->json('other_elements')->nullable()->comment('Additional chemical elements');
            
            // Physical Properties
            $table->decimal('melting_point', 8, 2)->nullable()->comment('°C');
            $table->decimal('thermal_conductivity', 8, 4)->nullable()->comment('W/m·K');
            $table->decimal('electrical_resistivity', 12, 6)->nullable()->comment('Ω·m');
            $table->decimal('coefficient_thermal_expansion', 8, 6)->nullable()->comment('1/K');
            
            // Standards and Specifications
            $table->string('astm_standard')->nullable();
            $table->string('din_standard')->nullable();
            $table->string('iso_standard')->nullable();
            $table->json('other_standards')->nullable();
            
            // Additional Properties
            $table->json('custom_properties')->nullable()->comment('Flexible storage for additional properties');
            
            // Status and metadata
            $table->boolean('is_active')->default(true);
            $table->string('supplier')->nullable();
            $table->decimal('cost_per_unit', 10, 4)->nullable();
            $table->string('cost_unit', 10)->nullable()->default('kg');
            
            $table->timestamps();
            
            // Indexes
            $table->index(['mat_family_id', 'mat_form_id']);
            $table->index(['is_active']);
            $table->index(['name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('mat_materials');
    }
};
