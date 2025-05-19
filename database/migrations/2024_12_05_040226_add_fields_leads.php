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
        Schema::table('chats_others', function (Blueprint $table) {
            $table->string('type'); // Default value set
            
            $table->unsignedBigInteger('leads_id')->nullable();
            $table->foreign('leads_id')->references('id')->on('leads')->onDelete('cascade');

            $table->unsignedBigInteger('suppliers_id')->nullable();
            $table->foreign('suppliers_id')->references('id')->on('suppliers')->onDelete('cascade');
    });            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats_others', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('leads_id');
            $table->dropColumn('suppliers_id');
        });            
    }
};
