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
        Schema::table('stock_sell', function (Blueprint $table) {
            $table->string('dimensions_per_unit_type')->nullable();
            $table->string('dimension_per_unit')->nullable();
            $table->string('dimension_per_unit_type')->nullable();
            $table->string('master_packing')->nullable();
            $table->string('master_packing_unit')->nullable();
            $table->string('weight_per_unit_type')->nullable();
            $table->string('rate_unit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_sell', function (Blueprint $table) {
            $table->dropColumn([
                'dimensions_per_unit_type',
                'dimension_per_unit',
                'dimension_per_unit_type',
                'master_packing',
                'master_packing_unit',
                'weight_per_unit_type',
                'rate_unit',
            ]);
        });
    }
};
