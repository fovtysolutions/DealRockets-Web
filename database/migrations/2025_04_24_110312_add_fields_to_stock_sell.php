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
            $table->string('upper_limit')->nullable();
            $table->string('lower_limit')->nullable();
            $table->string('unit')->nullable();
            $table->string('city')->nullable();
            $table->string('stock_type')->nullable();
            $table->string('product_type')->nullable();
            $table->string('origin')->nullable();
            $table->string('badge')->nullable();
            $table->string('refundable')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_sell', function (Blueprint $table) {
            $table->dropColumn('upper_limit');
            $table->dropColumn('lower_limit');
            $table->dropColumn('unit');
            $table->dropColumn('city');
            $table->dropColumn('stock_type');
            $table->dropColumn('product_type');
            $table->dropColumn('origin');
            $table->dropColumn('badge');
            $table->dropColumn('refundable');
        });
    }
};
