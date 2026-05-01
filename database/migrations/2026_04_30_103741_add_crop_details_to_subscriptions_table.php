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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('crop_variety')->nullable()->after('product_id')->comment('Specific variety of the crop, e.g., SC533, Hybrid 501');
            $table->decimal('land_size', 10, 2)->nullable()->after('crop_variety')->comment('Land size allocated to this crop in hectares');
            $table->integer('expected_yield_tonnes')->nullable()->after('land_size')->comment('Expected annual yield for this crop in tonnes');
            $table->string('planting_season')->nullable()->after('expected_yield_tonnes')->comment('Main planting season');
            $table->text('notes')->nullable()->after('planting_season')->comment('Additional farming notes');
            
            // Add index for price floor queries
            $table->index(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['crop_variety', 'land_size', 'expected_yield_tonnes', 'planting_season', 'notes']);
        });
    }
};
