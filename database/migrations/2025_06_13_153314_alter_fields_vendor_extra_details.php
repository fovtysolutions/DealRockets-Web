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
        Schema::table('vendor_extra_details', function (Blueprint $table) {
            $table->string('company_name')->nullable()->change();
            $table->string('business_type')->nullable()->change();
            $table->string('seller_id')->nullable()->change();
            $table->string('role')->nullable()->change();
            $table->string('year_of_establishment')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('vendor_extra_details', function (Blueprint $table) {
            $table->string('company_name')->change();
            $table->string('business_type')->change();
            $table->string('seller_id')->change();
            $table->string('role')->change();
            $table->year('year_of_establishment')->change();
        });
    }
};
