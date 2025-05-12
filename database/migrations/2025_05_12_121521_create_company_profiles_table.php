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
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            // Basic
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('description_head')->nullable();
            $table->text('description_text')->nullable();
            $table->json('images')->nullable(); // store paths in array
            $table->json('certificates')->nullable(); // store certificate file names

            // Basic Info
            $table->string('total_capitalization')->nullable();
            $table->year('year_established')->nullable();
            $table->string('total_employees')->nullable();
            $table->json('company_certificates')->nullable();
            $table->json('product_certificates')->nullable();
            $table->string('business_type')->nullable();

            // Trading Capabilities
            $table->string('total_annual_sales')->nullable();
            $table->integer('export_percentage')->nullable();
            $table->boolean('oem_service')->default(false);
            $table->boolean('small_orders_accepted')->default(false);
            $table->json('main_export_markets')->nullable();
            $table->json('payment_terms')->nullable();
            $table->json('delivery_terms')->nullable();

            // Company Show
            $table->json('hot_products')->nullable(); // limit in frontend
            $table->json('product_categories')->nullable();

            // Production
            $table->string('factory_size')->nullable();
            $table->integer('production_lines')->nullable();
            $table->string('monthly_output')->nullable();
            $table->json('main_products')->nullable();
            $table->string('lead_time')->nullable();

            // Quality Control
            $table->integer('qc_staff_count')->nullable();
            $table->text('inspection_process')->nullable();
            $table->json('testing_equipment')->nullable();
            $table->json('qc_certifications')->nullable();

            // R&D
            $table->integer('rd_staff_count')->nullable();
            $table->integer('patents')->nullable();
            $table->string('annual_rd_spending')->nullable();
            $table->boolean('customization_offered')->default(false);
            $table->string('product_dev_time')->nullable();

            // Contact
            $table->text('address')->nullable();
            $table->string('local_time')->nullable();
            $table->string('telephone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('showroom')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_dept')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            // Foreign Link
            $table->string('seller');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
