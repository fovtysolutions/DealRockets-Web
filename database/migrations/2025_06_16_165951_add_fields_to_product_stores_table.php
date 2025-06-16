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
            $table->string('role');
            $table->string('user_id');
            $table->string('supply_unit');
            $table->string('local_currency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_product_stores', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('user_id');
            $table->dropColumn('supply_unit');
            $table->dropColumn('local_currency');
        });
    }
};
