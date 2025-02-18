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
        Schema::create('membership_tiers',function(Blueprint $table){
            $table->id();
            $table->integer('membership_id');
            $table->longText('membership_benefits');
            $table->string('membership_name');
            $table->string('membership_type');
            $table->string('membership_active');
            $table->integer('membership_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_tiers');
    }
};
