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
        Schema::table('products', function (Blueprint $table) {
            $table->string('supply_capacity')->nullable();
            $table->string('supply_unit')->nullable();
            $table->string('local_currency')->nullable();
            $table->string('delivery_terms')->nullable();
            $table->string('delivery_mode')->nullable();
            $table->string('place_of_loading')->nullable();
            $table->string('port_of_loading')->nullable();
            $table->string('lead_time_unit')->nullable();
            $table->longText('target_market')->nullable();
            $table->string('short_details')->nullable();
            $table->string('certificate')->nullable();
            $table->longText('technical_specification');
            $table->longText('additional_details')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'supply_capacity',
                'supply_unit',
                'local_currency',
                'delivery_terms',
                'delivery_mode',
                'place_of_loading',
                'port_of_loading',
                'lead_time_unit',
                'target_market',
                'short_details',
                'certificate',
                'technical_specification',
            ]);
            $table->json('additional_details')->nullable()->change();
        });
    }
};
