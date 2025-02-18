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
        Schema::table('sellers',function(Blueprint $table){
            $table->string('vendor_type')->default('vendor')->change();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->tinyInteger('suppliers_confirm_status')->default('0');
            $table->longText('mem_benefits')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers',function(Blueprint $table){
            $table->string('vendor_type')->change();
            $table->dropForeign('suppliers_supplier_id_foreign');
            $table->dropColumn('supplier_id');
            $table->dropColumn('suppliers_confirm_status');
            $table->longText('mem_benefits');
        });
    }
};
