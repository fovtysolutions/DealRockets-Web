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
        Schema::table('users',function(Blueprint $table){
            $table->integer('terms_accepted');
            $table->longText('mem_benefits')->nullable();
            $table->boolean('lead_notif')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users',function(Blueprint $table){
            $table->dropColumn('terms_accepted');
            $table->dropColumn('mem_benefits');
            $table->dropColumn('lead_notif');
        });
    }
};
