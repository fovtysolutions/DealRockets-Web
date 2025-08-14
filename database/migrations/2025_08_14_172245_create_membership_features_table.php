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
        Schema::create('membership_features', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // sale_offer_limit, buy_leads_limit, etc.
            $table->string('name'); // Sale Offer Limit, Buy Leads Limit, etc.
            $table->string('description')->nullable();
            $table->string('type')->default('limit'); // limit, boolean, numeric, string
            $table->string('unit')->nullable(); // /month, /year, items, etc.
            $table->boolean('is_topup_enabled')->default(false);
            $table->decimal('topup_price_per_unit', 10, 2)->nullable();
            $table->string('category')->default('general'); // general, leads, jobs, products, etc.
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_features');
    }
};
