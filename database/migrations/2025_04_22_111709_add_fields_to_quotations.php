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
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('target_unit_price')->nullable();
            $table->string('target_unit_price_currency')->nullable();
            $table->string('max_budget')->nullable();
            $table->string('max_budget_currency')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('destination_port')->nullable();
            $table->string('destination_port_currency')->nullable();
            $table->string('spin_time')->nullable();
            $table->string('terms')->nullable();
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('target_unit_price');
            $table->dropColumn('target_unit_price_currency');
            $table->dropColumn('max_budget');
            $table->dropColumn('max_budget_currency');
            $table->dropColumn('shipping_method');
            $table->dropColumn('destination_port');
            $table->dropColumn('destination_port_currency');
            $table->dropColumn('spin_time');
            $table->dropColumn('terms');
            $table->dropColumn('image');
        });
    }
};
