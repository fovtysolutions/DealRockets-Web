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
        Schema::create('chatbot_negotiations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deal_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('seller_id');
            $table->decimal('original_price', 10, 2);
            $table->decimal('offered_price', 10, 2);
            $table->decimal('counter_price', 10, 2)->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'counter_offered'])->default('pending');
            $table->text('message')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->enum('negotiation_type', ['price', 'quantity', 'terms'])->default('price');
            $table->json('metadata')->nullable();
            $table->timestamps();

            // Foreign keys will be added later when tables exist
            $table->index('deal_id');
            $table->index('user_id');
            $table->index('seller_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_negotiations');
    }
};
