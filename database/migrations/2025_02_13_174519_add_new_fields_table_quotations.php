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
        Schema::table('quotations',function(Blueprint $table){
            $table->string('type');
            $table->string('country');
            $table->string('industry');
            $table->string('term');
            $table->string('unit');
            $table->string('buying_frequency');
            $table->string('converted_lead')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'country',
                'industry',
                'term',
                'unit',
                'buying_frequency',
                'converted_lead'
            ]);
        });
    }
};
