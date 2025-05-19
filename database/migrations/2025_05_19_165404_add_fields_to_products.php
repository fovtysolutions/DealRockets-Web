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
        Schema::table('products', function (Blueprint $table) {
            // PRODUCT INFORMATION
            $table->string('customization')->nullable();
            $table->string('style')->nullable();
            $table->string('usage')->nullable();
            $table->string('sample_price')->nullable();
            $table->string('sample_amount')->nullable();
            $table->string('model_number')->nullable();
            $table->boolean('small_orders')->default(false);
            $table->json('additional_details')->nullable();
            $table->text('faq')->nullable();
            $table->text('why_choose_us')->nullable();

            // SHIPPING INFORMATION
            $table->string('fob_port')->nullable();
            $table->string('weight_per_unit')->nullable();
            $table->string('hts_code')->nullable();
            $table->string('export_carton_dimensions')->nullable();
            $table->string('logistics_attributes')->nullable();
            $table->string('lead_time')->nullable();
            $table->string('dimensions_per_unit')->nullable();
            $table->string('units_per_carton')->nullable();
            $table->string('carton_weight')->nullable();

            // MAIN EXPORT MARKETS
            $table->text('export_markets')->nullable();

            // PAYMENT DETAILS
            $table->string('payment_methods')->nullable();
            $table->string('currency_accepted')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('invoicing')->nullable();
            $table->text('refund_policy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'customization',
                'style',
                'usage',
                'sample_price',
                'sample_amount',
                'model_number',
                'small_orders',
                'additional_details',
                'faq',
                'why_choose_us',
                'fob_port',
                'weight_per_unit',
                'hts_code',
                'export_carton_dimensions',
                'logistics_attributes',
                'lead_time',
                'dimensions_per_unit',
                'units_per_carton',
                'carton_weight',
                'export_markets',
                'payment_methods',
                'currency_accepted',
                'payment_terms',
                'invoicing',
                'refund_policy',
            ]);
        });
    }
};
