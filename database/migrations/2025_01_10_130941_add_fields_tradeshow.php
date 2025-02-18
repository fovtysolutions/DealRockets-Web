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
        Schema::table('tradeshows',function(Blueprint $table){
            $table->string('company_icon');
            $table->string('featured');
            $table->integer('popularity');
            $table->string('email');
            $table->string('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tradeshows',function(Blueprint $table){
            $table->dropColumn('company_icon');
            $table->dropColumn('featured');
            $table->dropColumn('popularity');
            $table->dropColumn('email');
            $table->dropColumn('phone');
        });
    }
};
