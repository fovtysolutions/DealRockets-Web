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
        Schema::create('chatbot_user_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('language_code', 10)->default('en');
            $table->json('notification_preferences')->nullable();
            $table->json('search_preferences')->nullable();
            $table->json('location_preferences')->nullable();
            $table->json('price_range_preferences')->nullable();
            $table->json('category_preferences')->nullable();
            $table->timestamps();

            // Foreign keys will be added later when tables exist
            $table->index('user_id');
            $table->index('language_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_user_preferences');
    }
};
