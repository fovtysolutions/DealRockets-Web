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
        Schema::table('stock_sell',function(Blueprint $table){
            $table->string('industry');
            $table->string('company_name');
            $table->string('company_address');
            $table->string('company_icon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_sell',function(Blueprint $table){
            $table->dropColumn('industry');
            $table->dropColumn('company_name');
            $table->dropColumn('company_address');
            $table->dropColumn('company_icon');
        });
    }
};
