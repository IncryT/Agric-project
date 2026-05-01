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
        Schema::create('farmer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Farm basic info
            $table->string('farm_name')->nullable();
            $table->text('farm_address')->nullable();
            $table->string('farm_phone')->nullable();
            
            // Land and crops
            $table->decimal('total_land_size', 10, 2)->nullable()->comment('Total farm size in hectares');
            $table->string('land_unit', 20)->default('hectares')->comment('hectares or acres');
            $table->json('crop_varieties')->nullable()->comment('Array of crop varieties grown');
            $table->text('other_crops')->nullable();
            
            // Farm details
            $table->enum('irrigation_type', ['none', 'drip', 'sprinkler', 'furrow', 'other'])->default('none');
            $table->enum('soil_type', ['clay', 'sandy', 'loam', 'silt', 'other'])->nullable();
            $table->integer('farming_experience_years')->nullable()->comment('Years of farming experience');
            $table->enum('main_market', ['mbare', 'local', 'export', 'contract', 'other'])->default('local');
            
            // Business info
            $table->string('cooperative_name')->nullable();
            $table->string('business_type', 50)->nullable()->comment('subsistence, commercial, etc');
            $table->decimal('expected_annual_yield', 12, 2)->nullable()->comment('In tonnes');
            
            $table->timestamps();
            
            // Indexes for queries
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farmer_profiles');
    }
};
