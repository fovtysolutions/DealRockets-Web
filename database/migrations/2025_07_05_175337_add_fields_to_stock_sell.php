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
            $table->string('product_code');
            $table->string('delivery_mode');
            $table->string('payment_terms');
            $table->string('certificate_name');

            $table->string('quantity')->change();
            $table->string('name')->nullable()->change();
            $table->string('country')->nullable()->change();

            // Add company details
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_icon')->nullable();

            // Drop foreign key constraint (if exists) and change product_id to string
            $table->dropForeign(['product_id']); // will fail if constraint doesn't exist
            $table->string('product_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_sell', function (Blueprint $table) {
            $table->dropColumn('product_code');
            $table->dropColumn('delivery_mode');
            $table->dropColumn('payment_terms');
            $table->dropColumn('certificate_name');

            $table->dropColumn('company_name');
            $table->dropColumn('company_address');
            $table->dropColumn('company_icon');

            $table->integer('quantity')->change();
            $table->string('name')->change();
            $table->string('country')->change();

            // Change product_id back to integer and restore foreign key if needed
            $table->integer('product_id')->change();
            // Add this if foreign key needs to be restored
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }
};
