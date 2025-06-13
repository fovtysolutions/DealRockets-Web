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
        Schema::table('leads', function (Blueprint $table) {
            $table->unsignedBigInteger('sub_category_id')->nullable()->after('product_id');
            $table->string('hs_code')->nullable()->after('sub_category_id');
            $table->string('rate')->nullable()->after('hs_code');
            $table->string('delivery_terms')->nullable()->after('rate');
            $table->string('delivery_mode')->nullable()->after('delivery_terms');
            $table->string('place_of_loading')->nullable()->after('delivery_mode');
            $table->string('port_of_loading')->nullable()->after('place_of_loading');
            $table->string('packing_type')->nullable()->after('port_of_loading');
            $table->longText('dynamic_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'sub_category_id',
                'hs_code',
                'rate',
                'delivery_terms',
                'delivery_mode',
                'place_of_loading',
                'port_of_loading',
                'packing_type',
                'dynamic_data'
            ]);
        });
    }
};
