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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['buyer', 'seller']); // Type of lead: buyer or seller
            $table->string('name'); // Name of the buyer or seller
            $table->string('country'); // Country of the individual or company
            $table->string('company_name')->nullable(); // Company name (optional)
            $table->string('contact_number')->nullable(); // Contact number (optional)
            $table->date('posted_date'); // Date of posting
            $table->string('quantity_required')->nullable(); // Quantity required (for buyers)
            $table->string('buying_frequency')->nullable(); // Buying frequency (for buyers)
            $table->text('details'); // Details of the lead
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
