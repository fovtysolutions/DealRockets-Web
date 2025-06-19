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
        Schema::table('new_product_stores', function (Blueprint $table) {
            $table->string('dimension_unit');
            $table->string('master_packing');
            $table->string('container');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_product_stores', function (Blueprint $table) {
            $table->dropColumn('dimension_unit');
            $table->dropColumn('master_packing');
            $table->dropColumn('container');
        });
    }
};
