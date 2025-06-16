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
        Schema::create('new_product_stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();

            $table->string('name');
            $table->string('hts_code')->nullable();

            $table->string('thumbnail')->nullable();
            $table->longText('extra_images')->nullable();

            $table->string('origin')->nullable();
            $table->integer('minimum_order_qty')->nullable();
            $table->string('unit')->nullable();

            $table->string('supply_capacity')->nullable();
            $table->decimal('unit_price', 15, 2)->nullable();

            $table->string('delivery_terms')->nullable();
            $table->string('delivery_mode')->nullable();
            $table->string('place_of_loading')->nullable();
            $table->string('port_of_loading')->nullable();

            $table->string('lead_time')->nullable();
            $table->string('lead_time_unit')->nullable();

            $table->string('payment_terms')->nullable();
            $table->string('packing_type')->nullable();

            $table->string('weight_per_unit')->nullable();
            $table->string('dimensions_per_unit')->nullable();

            $table->string('target_market')->nullable();
            $table->string('brand')->nullable();

            $table->text('short_details')->nullable();
            $table->longText('details')->nullable();

            $table->longText('dynamic_data')->nullable();              // Standard spec
            $table->longText('dynamic_data_technical')->nullable();    // Technical spec

            $table->longText('certificates')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_product_stores');
    }
};
