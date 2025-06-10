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
        Schema::create('vendor_extra_details', function (Blueprint $table) {
            $table->id();

            // Section 1: Company Information
            $table->string('company_name');
            $table->string('registered_business_name')->nullable();
            $table->enum('business_type', ['Manufacturer', 'Trader', 'Exporter', 'Service']);
            $table->year('year_of_establishment')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('country_of_registration')->nullable();
            $table->string('tax_id')->nullable();
            $table->date('tax_expiry')->nullable();
            $table->string('industry_category')->nullable();
            $table->text('main_products_services')->nullable();

            // Section 2: Office & Contact Details
            $table->text('head_office_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('website')->nullable();

            // Section 3: Contact Person
            $table->string('contact_person_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('alt_contact')->nullable();

            // Section 4: Banking Details
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('swift_code')->nullable();
            $table->text('bank_address')->nullable();
            $table->string('currency')->nullable();

            // Section 5: Branches & Global Presence
            $table->json('local_branches')->nullable();       // [{"city": "", "address": "", "contact": ""}]
            $table->json('overseas_offices')->nullable();     // [{"country": "", "contact_person": ""}]
            $table->json('export_countries')->nullable();     // ["UAE", "India", ...]
            $table->json('warehousing_locations')->nullable(); // [{"country": "", "city": ""}]

            // Section 6: Business Documentation
            $table->string('business_license_path')->nullable();       // PDF/JPG
            $table->string('tax_certificate_path')->nullable();        // PDF
            $table->string('import_export_license_path')->nullable();  // PDF
            $table->string('bank_proof_path')->nullable();             // PDF/Image
            $table->string('authority_id_path')->nullable();           // PDF (optional)
            $table->string('authority_name')->nullable();
            $table->string('authority_designation')->nullable();
            $table->string('authority_contact')->nullable();
            $table->string('authority_email')->nullable();
            $table->string('business_card_path')->nullable();          // optional

            // Section 7: Declarations
            $table->boolean('is_operational')->default(false);
            $table->boolean('is_info_verified')->default(false);
            $table->boolean('has_authorized_consent')->default(false);
            $table->string('authorized_name')->nullable();
            $table->string('authorized_signature_path')->nullable();   // digital signature if uploaded

            // Images
            $table->json('company_images')->nullable();     // max 3
            $table->json('factory_images')->nullable();     // max 3

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_extra_details');
    }
};
