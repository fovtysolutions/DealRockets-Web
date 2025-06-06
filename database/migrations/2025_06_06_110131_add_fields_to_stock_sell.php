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
            $table->string('sub_category_id')->nullable();
            $table->string('hs_code')->nullable();
            $table->integer('rate')->nullable();
            $table->string('local_currency')->nullable();
            $table->string('delivery_terms')->nullable();
            $table->string('place_of_loading')->nullable();
            $table->string('port_of_loading')->nullable();
            $table->string('packing_type')->nullable();
            $table->string('weight_per_unit')->nullable();
            $table->string('dimensions_per_unit')->nullable();
            $table->string('certificate')->nullable();
            $table->string('dynamic_data')->nullable();
            $table->string('dynamic_data_technical')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_sell', function (Blueprint $table) {
            $table->dropColumn([
                'sub_category_id',
                'hs_code',
                'rate',
                'local_currency',
                'delivery_terms',
                'place_of_loading',
                'port_of_loading',
                'packing_type',
                'weight_per_unit',
                'dimensions_per_unit',
                'certificate',
                'dynamic_data',
                'dynamic_data_technical',
            ]);
        });
    }
};
