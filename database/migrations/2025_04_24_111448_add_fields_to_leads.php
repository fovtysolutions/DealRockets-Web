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
            $table->string('city')->nullable();
            $table->string('tags')->nullable();
            $table->string('refund')->nullable();
            $table->string('avl_stock')->nullable();
            $table->string('avl_stock_unit')->nullable();
            $table->string('lead_time')->nullable();
            $table->string('brand')->nullable();
            $table->string('payment_option')->nullable();
            $table->string('offer_type')->nullable();
            $table->string('size')->nullable();
            $table->longText('images')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('tags');
            $table->dropColumn('refund');
            $table->dropColumn('avl_stock');
            $table->dropColumn('avl_stock_unit');
            $table->dropColumn('lead_time');
            $table->dropColumn('brand');
            $table->dropColumn('payment_option');
            $table->dropColumn('offer_type');
            $table->dropColumn('size');
            $table->dropColumn('images');
        });
    }
};
