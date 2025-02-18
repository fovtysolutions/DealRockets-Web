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
        Schema::create('tradeshows', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('hall');
            $table->string('stand');
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('description');
            $table->string('website');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tradeshows');
    }
};
