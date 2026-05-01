<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('market_prices', function (Blueprint $table) {
            $table->dropColumn(['market_1_price', 'market_2_price', 'daily_average_price']);
            $table->decimal('price', 10, 2)->after('date');
        });
    }

    public function down(): void
    {
        Schema::table('market_prices', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->decimal('market_1_price', 10, 2)->unsigned();
            $table->decimal('market_2_price', 10, 2)->unsigned();
            $table->decimal('daily_average_price', 10, 2)->unsigned()->nullable();
        });
    }
};
