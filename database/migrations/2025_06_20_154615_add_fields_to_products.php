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
            $table->longText('extra_images')->nullable();
            $table->longText('dynamic_data');
            $table->longText('dynamic_data_technical');
            $table->string('certificates');
            $table->string('dimension_unit');
            $table->string('master_packing');
            $table->string('container');
            $table->string('brand')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('extra_images');
            $table->dropColumn('dynamic_data');
            $table->dropColumn('dynamic_data_technical');
            $table->dropColumn('certificates');
            $table->dropColumn('dimension_unit');
            $table->dropColumn('master_packing');
            $table->dropColumn('container');
        });
    }
};
