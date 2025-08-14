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
        Schema::create('membership_tier_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_tier_id')->constrained()->onDelete('cascade');
            $table->foreignId('membership_feature_id')->constrained()->onDelete('cascade');
            $table->string('value'); // The limit/value for this feature in this tier
            $table->boolean('is_unlimited')->default(false);
            $table->timestamps();
            
            $table->unique(['membership_tier_id', 'membership_feature_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_tier_features');
    }
};
